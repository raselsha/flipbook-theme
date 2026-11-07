/* Features tabs (#features). With room on screen the section pins while the
   page scrolls, and scroll position picks the tab; otherwise the tabs rotate
   on a timer while the section is in view. Clicking a tab jumps to it. */
(function () {
  var root = document.querySelector('[data-features]');
  var track = document.querySelector('[data-feature-track]');
  if (!root || !track) return;

  var tabs = Array.prototype.slice.call(root.querySelectorAll('.feature-list > li'));
  var panels = Array.prototype.slice.call(root.querySelectorAll('.fpanel'));
  var badge = root.querySelector('.scene-badge');
  var badgeSmall = root.querySelector('[data-fbadge-small]');
  var badgeBig = root.querySelector('[data-fbadge]');
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var STEP = 340, DUR = 4500;
  var idx = -1, mode = '', timer = 0, visible = false, ticking = false;

  function header() {
    var h = document.querySelector('.site-header');
    return (h ? h.getBoundingClientRect().height : 72) + 24;
  }

  function countUp(panel) {
    Array.prototype.forEach.call(panel.querySelectorAll('[data-count-to]'), function (el) {
      var to = parseInt(el.getAttribute('data-count-to'), 10) || 0, t0 = performance.now(), d = reduce ? 1 : 1200;
      (function step(t) {
        var k = Math.min(1, (t - t0) / d), e = 1 - Math.pow(1 - k, 3);
        el.textContent = Math.round(to * e).toLocaleString();
        if (k < 1) requestAnimationFrame(step);
      })(t0);
    });
  }

  function activate(i, force) {
    if (i === idx && !force) return;
    idx = i;
    tabs.forEach(function (t, k) {
      var on = k === i;
      t.classList.toggle('is-active', on);
      t.setAttribute('aria-selected', on ? 'true' : 'false');
      t.setAttribute('tabindex', on ? '0' : '-1');
    });
    panels.forEach(function (p, k) {
      var on = k === i;
      p.classList.toggle('is-on', on);
      p.setAttribute('aria-hidden', on ? 'false' : 'true');
    });
    if (badge) {
      badge.classList.add('is-swap');
      setTimeout(function () {
        badgeSmall.textContent = tabs[i].getAttribute('data-badge-small');
        badgeBig.textContent = tabs[i].getAttribute('data-badge');
        badge.classList.remove('is-swap');
      }, 200);
    }
    if (panels[i]) countUp(panels[i]);
    if (mode === 'timer') restartTimer();
  }

  /* ---- scroll mode ---- */
  function onScroll() {
    ticking = false;
    if (mode !== 'scroll') return;
    var range = track.offsetHeight - root.offsetHeight;
    var p = (header() - track.getBoundingClientRect().top) / Math.max(1, range);
    p = Math.min(0.9999, Math.max(0, p));
    var pos = p * tabs.length, i = Math.floor(pos);
    activate(i);
    root.style.setProperty('--fprog', (pos - i).toFixed(3));
  }
  function queue() { if (!ticking) { ticking = true; requestAnimationFrame(onScroll); } }

  /* ---- timer mode ---- */
  function restartTimer() {
    clearTimeout(timer);
    var bar = tabs[idx] && tabs[idx].querySelector('.feature-prog');
    if (bar) { bar.style.animation = 'none'; void bar.offsetWidth; bar.style.animation = ''; }
    if (mode === 'timer' && visible && !document.hidden) {
      timer = setTimeout(function () { activate((idx + 1) % tabs.length); }, DUR);
    }
  }

  function layout() {
    var fits = window.innerWidth >= 1000 && window.innerHeight >= root.offsetHeight + header() + 16;
    var next = fits ? 'scroll' : 'timer';
    root.style.setProperty('--fsticky', header() + 'px');
    if (next === 'scroll') track.style.height = (root.offsetHeight + STEP * tabs.length) + 'px';
    if (next === mode) { if (mode === 'scroll') onScroll(); return; }
    mode = next;
    root.classList.toggle('is-sticky', mode === 'scroll');
    root.classList.toggle('is-timer', mode === 'timer');
    root.style.setProperty('--fdur', DUR + 'ms');
    if (mode === 'scroll') { clearTimeout(timer); onScroll(); }
    else { track.style.height = ''; root.style.removeProperty('--fprog'); restartTimer(); }
  }

  tabs.forEach(function (t, k) {
    function go() {
      if (mode === 'scroll') {
        var top = track.getBoundingClientRect().top + window.pageYOffset - header();
        window.scrollTo({ top: top + k * STEP + 2, behavior: reduce ? 'auto' : 'smooth' });
      } else {
        activate(k, true);
      }
    }
    t.addEventListener('click', go);
    t.addEventListener('keydown', function (e) {
      if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); go(); }
      if (e.key === 'ArrowDown' || e.key === 'ArrowUp') {
        e.preventDefault();
        var n = (k + (e.key === 'ArrowDown' ? 1 : tabs.length - 1)) % tabs.length;
        tabs[n].focus(); tabs[n].click();
      }
    });
  });

  window.addEventListener('scroll', queue, { passive: true });
  window.addEventListener('resize', function () { layout(); });
  document.addEventListener('visibilitychange', restartTimer);
  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (entries) {
      visible = entries[0].isIntersecting;
      restartTimer();
    }, { threshold: 0.35 }).observe(root);
  } else {
    visible = true;
  }
  activate(0, true);
  layout();
})();
