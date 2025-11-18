document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const header = document.querySelector('.site-header');
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('[data-site-nav]');
  const backdrop = document.querySelector('.nav-backdrop');
  const ctaContainer = nav ? nav.querySelector('[data-header-cta]') : null;
  const searchToggle = document.querySelector('[data-search-toggle]');
  const searchPanel = document.querySelector('[data-search-panel]');
  const searchClose = document.querySelector('[data-search-close]');
  const searchInput = searchPanel ? searchPanel.querySelector('input[type="search"]') : null;
  const submenuState = [];
  const desktopMedia = window.matchMedia('(min-width: 901px)');
  const isMobileView = () => !desktopMedia.matches;
  let setNavStateRef = null;
  let resizeTimer;

  const syncSearchPanelForViewport = () => {
    if (!searchPanel) return;

    if (isMobileView()) {
      body.classList.remove('search-active');
      searchPanel.setAttribute('aria-hidden', 'false');
      if (searchToggle) {
        searchToggle.setAttribute('aria-expanded', 'false');
      }
    } else {
      const isOpen = body.classList.contains('search-active');
      searchPanel.setAttribute('aria-hidden', isOpen ? 'false' : 'true');
    }
  };

  const setSearchState = (isOpen) => {
    if (!searchPanel || !searchToggle) return;

    if (isMobileView()) {
      syncSearchPanelForViewport();
      return;
    }

    if (isOpen && setNavStateRef) {
      setNavStateRef(false);
    }

    body.classList.toggle('search-active', isOpen);
    searchToggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

    if (isOpen) {
      window.requestAnimationFrame(() => {
        if (searchInput) {
          searchInput.focus();
        }
      });
    } else {
      searchToggle.focus();
    }

    syncSearchPanelForViewport();
  };

  const syncSubmenuStylesForViewport = () => {
    const isDesktop = desktopMedia.matches;

    submenuState.forEach(({ menuItem, submenu }) => {
      if (isDesktop) {
        menuItem.classList.remove('is-open');
        submenu.style.removeProperty('max-height');
        submenu.style.removeProperty('opacity');
        submenu.style.removeProperty('pointer-events');
        submenu.style.removeProperty('transform');
      } else {
        const isOpen = menuItem.classList.contains('is-open');
        submenu.style.maxHeight = isOpen ? `${submenu.scrollHeight}px` : '0px';
        submenu.style.opacity = isOpen ? '1' : '0';
        submenu.style.pointerEvents = isOpen ? 'auto' : 'none';
        submenu.style.transform = isOpen ? 'translateY(0)' : 'translateY(-6px)';
      }
    });
  };

  const handleResize = () => {
    body.classList.add('is-resizing');
    syncSubmenuStylesForViewport();
    syncSearchPanelForViewport();

    window.clearTimeout(resizeTimer);
    resizeTimer = window.setTimeout(() => {
      body.classList.remove('is-resizing');
      syncSubmenuStylesForViewport();
      syncSearchPanelForViewport();
    }, 250);
  };

  window.addEventListener('resize', handleResize, { passive: true });
  if (typeof desktopMedia.addEventListener === 'function') {
    desktopMedia.addEventListener('change', syncSubmenuStylesForViewport);
    desktopMedia.addEventListener('change', syncSearchPanelForViewport);
  } else if (typeof desktopMedia.addListener === 'function') {
    desktopMedia.addListener(syncSubmenuStylesForViewport);
    desktopMedia.addListener(syncSearchPanelForViewport);
  }

  if (toggle && nav) {
    const primaryMenu = nav.querySelector('.primary-menu');
    const getStateForItem = (item) =>
      submenuState.find(({ menuItem }) => menuItem === item);
    const setSubmenuOpen = (state, shouldOpen) => {
      if (!state) return;
      const { menuItem, toggleButton } = state;

      menuItem.classList.toggle('is-open', shouldOpen);
      toggleButton.setAttribute('aria-expanded', shouldOpen ? 'true' : 'false');
      syncSubmenuStylesForViewport();
    };

    if (primaryMenu) {
      const itemsWithChildren = primaryMenu.querySelectorAll(':scope > .menu-item-has-children');

      itemsWithChildren.forEach((menuItem) => {
        const trigger = menuItem.querySelector(':scope > a');
        const submenu = menuItem.querySelector(':scope > .sub-menu');

        if (!trigger || !submenu) {
          return;
        }

        const toggleButton = document.createElement('button');
        const label = trigger.textContent.trim();

        toggleButton.type = 'button';
        toggleButton.className = 'submenu-toggle';
        toggleButton.setAttribute('aria-expanded', 'false');
        toggleButton.setAttribute(
          'aria-label',
          label ? `${label}: submenu` : 'Toggle submenu'
        );
        toggleButton.innerHTML = '<span class="submenu-toggle__icon" aria-hidden="true"></span>';

        trigger.after(toggleButton);

        toggleButton.addEventListener('click', () => {
          const state = getStateForItem(menuItem);
          if (!state) return;
          const nextState = !state.menuItem.classList.contains('is-open');
          setSubmenuOpen(state, nextState);
        });

        submenuState.push({ menuItem, toggleButton, submenu });
      });

      syncSubmenuStylesForViewport();
    }

    const setNavState = (isOpen) => {
      if (isOpen && body.classList.contains('search-active')) {
        setSearchState(false);
      }

      body.classList.toggle('nav-open', isOpen);
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

      if (!isOpen) {
        submenuState.forEach((state) => {
          setSubmenuOpen(state, false);
        });
      }

      if (backdrop) {
        backdrop.classList.toggle('is-visible', isOpen);
        backdrop.setAttribute('aria-hidden', String(!isOpen));
      }

      if (ctaContainer) {
        if (isOpen) {
          ctaContainer.setAttribute('data-visible', 'true');
        } else {
          ctaContainer.removeAttribute('data-visible');
        }
      }
    };
    setNavStateRef = setNavState;

    toggle.addEventListener('click', () => {
      const nextState = !body.classList.contains('nav-open');
      setNavState(nextState);
    });

    nav.addEventListener('click', (event) => {
      const target = event.target instanceof HTMLElement ? event.target.closest('a') : null;
      if (!target) return;

      if (primaryMenu && primaryMenu.contains(target)) {
        const parentItem = target.closest('.menu-item-has-children');
        const directTrigger = parentItem && target === parentItem.querySelector(':scope > a');

        if (directTrigger && parentItem.querySelector('.submenu-toggle')) {
          event.preventDefault();
          const state = getStateForItem(parentItem);
          if (state) {
            const nextState = !parentItem.classList.contains('is-open');
            setSubmenuOpen(state, nextState);
          }
          return;
        }
      }

      setNavState(false);
    });

    if (backdrop) {
      backdrop.addEventListener('click', () => setNavState(false));
    }

    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && body.classList.contains('nav-open')) {
        setNavState(false);
        toggle.focus();
      }
    });
  }

  if (searchToggle && searchPanel) {
    searchToggle.addEventListener('click', () => {
      const nextState = !body.classList.contains('search-active');
      setSearchState(nextState);
    });
  }

  if (searchClose) {
    searchClose.addEventListener('click', () => setSearchState(false));
  }

  if (header) {
    const onScroll = () => {
      if (window.scrollY > 10) {
        header.classList.add('is-scrolled');
      } else {
        header.classList.remove('is-scrolled');
      }
    };

    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && body.classList.contains('search-active')) {
      event.preventDefault();
      setSearchState(false);
    }
  });

  syncSearchPanelForViewport();
});
