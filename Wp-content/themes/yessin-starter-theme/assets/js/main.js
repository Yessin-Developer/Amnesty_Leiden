document.addEventListener('DOMContentLoaded', () => {
  const body = document.body;
  const header = document.querySelector('.site-header');
  const toggle = document.querySelector('.nav-toggle');
  const nav = document.querySelector('.site-nav');
  const backdrop = document.querySelector('.nav-backdrop');

  if (toggle && nav) {
    const setNavState = (isOpen) => {
      body.classList.toggle('nav-open', isOpen);
      toggle.setAttribute('aria-expanded', isOpen ? 'true' : 'false');
      if (backdrop) {
        backdrop.classList.toggle('is-visible', isOpen);
        backdrop.setAttribute('aria-hidden', String(!isOpen));
      }
    };

    toggle.addEventListener('click', () => {
      const nextState = !body.classList.contains('nav-open');
      setNavState(nextState);
    });

    nav.addEventListener('click', (event) => {
      if (event.target instanceof HTMLAnchorElement) {
        setNavState(false);
      }
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
