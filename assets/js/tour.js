/* Product tour: walks a spotlight through the plugin's workflow
   (template-parts/product-tour.php). Starts when the tour scrolls into view,
   pauses while the pointer is over it, off screen, or the tab is hidden. */
(function () {
  var tour = document.querySelector('[data-tour]');
  if (!tour) return;

  var app = tour.querySelector('.tour-app');
  var spot = tour.querySelector('.tour-spot');
  var tip = tour.querySelector('.tour-tip');
  var tipTitle = tip.querySelector('[data-tip-title]');
  var tipText = tip.querySelector('[data-tip-text]');
  var urlEl = tour.querySelector('[data-tour-url]');
  var urls = {};
  try { urls = JSON.parse(tour.getAttribute('data-urls') || '{}'); } catch (e) {}
  var buttons = Array.prototype.slice.call(tour.querySelectorAll('.tour-step'));
  var reduce = window.matchMedia && window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  var idx = -1, timer = 0, timers = [], remaining = 0, startedAt = 0;
  var visible = false, hovering = false, started = false;

  function $(sel, root) { return (root || app).querySelector(sel); }
  function $$(sel, root) { return Array.prototype.slice.call((root || app).querySelectorAll(sel)); }
  function screen(name) { return $('[data-screen="' + name + '"]'); }
  function later(fn, ms) { timers.push(setTimeout(fn, reduce ? Math.min(ms, 50) : ms)); }
  function every(fn, ms) { var t = setInterval(fn, ms); timers.push({ i: t }); }
  function clearLater() {
    timers.forEach(function (t) { if (t && t.i) clearInterval(t.i); else clearTimeout(t); });
    timers = [];
  }

  /* ---- per-step state, applied before the spotlight is measured ---- */
  function setCount(book, spread) {
    var c = book && book.parentNode.querySelector('[data-count]');
    if (c) c.textContent = spread + ' / ' + c.getAttribute('data-total');
  }
  function setState(id) {
    var drop = $('.tour-drop'), pick = $('.tour-coverpick'), copy = $('.tour-copy');
    var site = screen('site'), book = $('.tour-book--ltr'), rtlBook = $('.tour-book--rtl');
    var typed = $('[data-type]');

    drop.classList.remove('is-uploading');
    drop.classList.toggle('is-done', id !== 'upload');
    var picked = id === 'copy';
    pick.classList.toggle('is-alt', picked);
    $$('.tour-thumb', pick).forEach(function (t, k) { t.classList.toggle('is-sel', picked ? k === 2 : k === 0); });
    copy.classList.remove('is-copied');
    copy.textContent = copy.getAttribute('data-copy-label');
    if (typed) typed.textContent = id === 'paste' ? '' : typed.getAttribute('data-type');

    var flipped = id === 'toolbar' || id === 'lock';
    if (book) { book.classList.toggle('is-flipped', flipped); setCount(book, flipped ? '4–5' : '2–3'); }
    if (rtlBook) { rtlBook.classList.remove('is-flipped'); setCount(rtlBook, '2–3'); }
    site.classList.toggle('is-locked', id === 'lock');
    $$('.tour-layout').forEach(function (l, k) { l.classList.toggle('is-sel', k === 0); });
    $$('.tour-shelfitem').forEach(function (s) { s.classList.remove('is-lift'); });
  }

  /* ---- per-step micro animations ---- */
  function act(id) {
    if (id === 'upload') {
      var drop = $('.tour-drop');
      later(function () { drop.classList.add('is-uploading'); }, 500);
      later(function () { drop.classList.add('is-done'); }, 2500);
    } else if (id === 'cover') {
      var pick = $('.tour-coverpick'), thumbs = $$('.tour-thumb', pick);
      later(function () {
        thumbs.forEach(function (t, k) { t.classList.toggle('is-sel', k === 2); });
        pick.classList.add('is-alt');
      }, 1500);
    } else if (id === 'copy') {
      var copy = $('.tour-copy');
      later(function () { copy.classList.add('is-copied'); copy.textContent = copy.getAttribute('data-copied-label'); }, 1300);
    } else if (id === 'paste') {
      var el = $('[data-type]'), text = el.getAttribute('data-type'), n = 0;
      later(function () {
        every(function () { if (n <= text.length) el.textContent = text.slice(0, n++); }, 55);
      }, 600);
    } else if (id === 'flip' || id === 'rtl') {
      var book = $(id === 'flip' ? '.tour-book--ltr' : '.tour-book--rtl');
      later(function () { book.classList.add('is-flipped'); }, 1000);
      later(function () { setCount(book, '4–5'); }, 2100);
    } else if (id === 'layouts') {
      var cards = $$('.tour-layout'), k = 0;
      every(function () { k = (k + 1) % cards.length; cards.forEach(function (c, j) { c.classList.toggle('is-sel', j === k); }); }, 950);
    } else if (id === 'shelf') {
      var items = $$('.tour-shelfitem'), s = -1;
      every(function () { s = (s + 1) % items.length; items.forEach(function (it, j) { it.classList.toggle('is-lift', j === s); }); }, 520);
    }
  }

  /* ---- spotlight + tooltip geometry ---- */
  function place() {
    var b = buttons[idx];
    if (!b) return;
    var target = $('[data-tour-target="' + b.getAttribute('data-target') + '"]', screen(b.getAttribute('data-screen')));
    if (!target) return;
    var a = app.getBoundingClientRect(), r = target.getBoundingClientRect();
    var pad = a.width * 0.006, gap = a.width * 0.016;
    var x = r.left - a.left - pad, y = r.top - a.top - pad, w = r.width + pad * 2, h = r.height + pad * 2;
    app.style.setProperty('--tour-x', x + 'px');
    app.style.setProperty('--tour-y', y + 'px');
    app.style.setProperty('--tour-w', w + 'px');
    app.style.setProperty('--tour-h', h + 'px');

    var tw = tip.offsetWidth, th = tip.offsetHeight, tx, ty, side = true;
    if (x + w + gap + tw <= a.width - gap) tx = x + w + gap;
    else if (x - gap - tw >= gap) tx = x - gap - tw;
    else { side = false; tx = Math.min(Math.max(x + w / 2 - tw / 2, gap), a.width - tw - gap); }
    if (side) ty = Math.min(Math.max(y + h / 2 - th / 2, gap), a.height - th - gap);
    else ty = (y + h + gap + th <= a.height - gap) ? y + h + gap : Math.max(y - gap - th, gap);
    app.style.setProperty('--tip-x', tx + 'px');
    app.style.setProperty('--tip-y', ty + 'px');
  }

  /* ---- timeline ---- */
  function paused() { return !visible || hovering || document.hidden; }
  function schedule() {
    clearTimeout(timer);
    tour.classList.toggle('is-paused', paused());
    if (paused()) return;
    startedAt = Date.now();
    timer = setTimeout(function () { go(idx + 1); }, remaining);
  }
  function pause() {
    if (timer) { clearTimeout(timer); timer = 0; remaining = Math.max(400, remaining - (Date.now() - startedAt)); }
    tour.classList.add('is-paused');
  }

  function go(i) {
    clearTimeout(timer);
    clearLater();
    idx = (i + buttons.length) % buttons.length;
    var b = buttons[idx], id = b.getAttribute('data-step'), name = b.getAttribute('data-screen');

    buttons.forEach(function (x, k) {
      var on = k === idx;
      x.classList.toggle('is-active', on);
      x.setAttribute('aria-selected', on ? 'true' : 'false');
      if (on) { x.style.setProperty('--ms', b.getAttribute('data-ms') + 'ms'); var bar = x.querySelector('.tour-step__bar'); bar.style.animation = 'none'; void bar.offsetWidth; bar.style.animation = ''; }
    });
    tour.setAttribute('data-step', id);
    $$('.tour-screen').forEach(function (s) { s.classList.toggle('is-on', s.getAttribute('data-screen') === name); });
    if (urlEl && urls[name]) urlEl.textContent = urls[name];

    setState(id);
    tip.classList.remove('is-on');
    tipTitle.textContent = b.getAttribute('data-title');
    tipText.textContent = b.getAttribute('data-text');
    requestAnimationFrame(function () {
      place();
      if (!tour.hasAttribute('data-ready')) requestAnimationFrame(function () { tour.setAttribute('data-ready', ''); });
      later(function () { tip.classList.add('is-on'); }, 380);
    });
    act(id);
    remaining = parseInt(b.getAttribute('data-ms'), 10) || 4000;
    schedule();
  }

  buttons.forEach(function (b, k) {
    b.addEventListener('click', function () { started = true; go(k); });
  });
  tour.querySelector('.tour-frame').addEventListener('mouseenter', function () { hovering = true; pause(); });
  tour.querySelector('.tour-frame').addEventListener('mouseleave', function () { hovering = false; schedule(); });
  document.addEventListener('visibilitychange', function () { if (document.hidden) pause(); else schedule(); });

  if ('IntersectionObserver' in window) {
    new IntersectionObserver(function (entries) {
      visible = entries[0].isIntersecting;
      if (visible && !started) { started = true; go(0); return; }
      if (visible) schedule(); else pause();
    }, { threshold: 0.3 }).observe(app);
  } else {
    visible = true; started = true; go(0);
  }
  if ('ResizeObserver' in window) {
    new ResizeObserver(function () { if (idx > -1) place(); }).observe(app);
  }
})();
