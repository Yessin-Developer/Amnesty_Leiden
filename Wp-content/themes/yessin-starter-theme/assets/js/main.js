document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const header = document.querySelector('.site-header');
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('[data-site-nav]');
  const backdrop = document.querySelector('.nav-backdrop');
  const ctaContainer = nav ? nav.querySelector('[data-header-cta]') : null;
  const submenuState = [];
  let resizeTimer;

  const handleResize = () => {
    body.classList.add('is-resizing');
    window.clearTimeout(resizeTimer);
    resizeTimer = window.setTimeout(() => {
      body.classList.remove('is-resizing');
    }, 250);
  };

  window.addEventListener('resize', handleResize, { passive: true });

  if (toggle && nav) {
    const primaryMenu = nav.querySelector('.primary-menu');

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
          const isOpen = menuItem.classList.toggle('is-open');
          toggleButton.setAttribute('aria-expanded', String(isOpen));
        });

        submenuState.push({ menuItem, toggleButton });
      });
    }

    const setNavState = (isOpen) => {
      body.classList.toggle('nav-open', isOpen);
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');

      if (!isOpen) {
        submenuState.forEach(({ menuItem, toggleButton }) => {
          menuItem.classList.remove('is-open');
          toggleButton.setAttribute('aria-expanded', 'false');
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
          parentItem.classList.toggle('is-open');
          const button = parentItem.querySelector('.submenu-toggle');
          if (button) {
            const isOpen = parentItem.classList.contains('is-open');
            button.setAttribute('aria-expanded', String(isOpen));
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
});
