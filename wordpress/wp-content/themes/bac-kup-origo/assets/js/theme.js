(function () {
  'use strict';

  const nav = document.getElementById('mainNav');
  if (nav) {
    const toggleShadow = function () {
      nav.classList.toggle('scrolled', window.scrollY > 20);
    };
    window.addEventListener('scroll', toggleShadow, { passive: true });
    toggleShadow();
  }

  const ham = document.getElementById('navHam');
  const menu = document.getElementById('mobMenu');
  const overlay = document.getElementById('mobOverlay');
  const hamIcon = document.getElementById('hamIcon');

  if (ham && menu && overlay && hamIcon) {
    const iconClose = '<line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>';
    const iconOpen = '<line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/>';

    const setMenu = function (open) {
      menu.classList.toggle('open', open);
      ham.setAttribute('aria-expanded', String(open));
      ham.setAttribute('aria-label', open ? 'Menu sluiten' : 'Menu openen');
      hamIcon.innerHTML = open ? iconClose : iconOpen;
      document.body.style.overflow = open ? 'hidden' : '';
    };

    ham.addEventListener('click', function () {
      setMenu(!menu.classList.contains('open'));
    });

    overlay.addEventListener('click', function () {
      setMenu(false);
    });

    menu.querySelectorAll('a').forEach(function (anchor) {
      anchor.addEventListener('click', function () {
        setMenu(false);
      });
    });

    document.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        setMenu(false);
      }
    });
  }

  const io = new IntersectionObserver(function (entries) {
    entries.forEach(function (entry) {
      if (entry.isIntersecting) {
        entry.target.classList.add('visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.07 });

  document.querySelectorAll('.reveal').forEach(function (el) {
    io.observe(el);
  });

  window.tog = function (btn) {
    const item = btn.closest('.faq-item');
    if (!item) {
      return;
    }

    const answer = item.querySelector('.faq-a');
    const wasOpen = item.classList.contains('open');

    document.querySelectorAll('.faq-item.open').forEach(function (openItem) {
      const openAnswer = openItem.querySelector('.faq-a');
      const openButton = openItem.querySelector('.faq-q');
      openItem.classList.remove('open');
      if (openAnswer) {
        openAnswer.hidden = true;
      }
      if (openButton) {
        openButton.setAttribute('aria-expanded', 'false');
      }
    });

    if (!wasOpen) {
      item.classList.add('open');
      if (answer) {
        answer.hidden = false;
      }
      btn.setAttribute('aria-expanded', 'true');
    }
  };

  document.querySelectorAll('.faq-item').forEach(function (item) {
    const answer = item.querySelector('.faq-a');
    const button = item.querySelector('.faq-q');
    item.classList.remove('open');
    if (answer) {
      answer.hidden = true;
    }
    if (button) {
      button.setAttribute('aria-expanded', 'false');
    }
  });

  window.submitForm = function () {
    const company = document.getElementById('fComp');
    const name = document.getElementById('fName');
    const email = document.getElementById('fEmail');
    const plan = document.getElementById('fPlan');
    const count = document.getElementById('fCount');
    const message = document.getElementById('fMsg');
    const check = document.getElementById('fCheck');
    const formArea = document.getElementById('formArea');
    const successArea = document.getElementById('successArea');
    const button = document.querySelector('button.btn-submit');

    if (!company || !name || !email || !plan || !check || !button) {
      return;
    }

    if (!company.value.trim() || !name.value.trim() || !email.value.trim() || !plan.value || !check.checked) {
      window.alert('Vul alle vereiste velden in en bevestig de medische gegevens disclaimer.');
      return;
    }

    button.disabled = true;
    button.textContent = 'Verzenden...';

    window.fetch('/api/contact.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        company: company.value.trim(),
        count: count ? count.value : '',
        plan: plan.value,
        name: name.value.trim(),
        email: email.value.trim(),
        message: message ? message.value.trim() : ''
      })
    }).then(function (response) {
      if (!response.ok) {
        throw new Error('server');
      }
      if (formArea) {
        formArea.hidden = true;
      }
      if (successArea) {
        successArea.hidden = false;
      }
    }).catch(function () {
      window.alert('Er is iets misgegaan. Probeer het opnieuw of mail naar info@origo.care.');
      button.disabled = false;
      button.innerHTML = 'Verstuur aanvraag';
    });
  };

  const tocLinks = document.querySelectorAll('.toc-list a');
  if (tocLinks.length) {
    const sections = document.querySelectorAll('.legal-section[id]');

    const onScroll = function () {
      let current = '';
      const offset = window.innerHeight * 0.25;

      sections.forEach(function (section) {
        if (section.getBoundingClientRect().top <= offset) {
          current = section.id;
        }
      });

      tocLinks.forEach(function (link) {
        link.classList.toggle('active', link.getAttribute('href') === '#' + current);
      });
    };

    window.addEventListener('scroll', onScroll, { passive: true });
    onScroll();
  }
})();
