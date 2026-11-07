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
  // Types text into el at ~ms per character, by elapsed time; calls done() at the end.
  function type(el, text, ms, done) {
    var t0 = Date.now();
    every(function () {
      var n = Math.min(text.length, Math.floor((Date.now() - t0) / ms));
      if (el.textContent.length !== n) el.textContent = text.slice(0, n);
      if (n >= text.length && done) { var d = done; done = null; d(); }
    }, 30);
  }
  function clearLater() {
    timers.forEach(function (t) { if (t && t.i) clearInterval(t.i); else clearTimeout(t); });
    timers = [];
  }

  /* ---- per-step state, applied before the spotlight is measured ---- */
  function setCount(book, spread) {
    var stage = book && book.closest('.tour-stage');
    var chrome = stage && stage.querySelector('.tour-chrome2');
    if (!chrome) return;
    var n = parseInt(spread, 10) || 2, total = parseInt(chrome.getAttribute('data-total'), 10) || 10;
    chrome.querySelector('[data-page]').textContent = n;
    chrome.style.setProperty('--progress', Math.min(100, Math.max(0, (n - 1) / Math.max(1, total - 1) * 100)) + '%');
    $$('[data-fx="first"],[data-fx="prev"]', chrome).forEach(function (b) { b.classList.toggle('is-off', n <= 1); });
    if (book.offsetWidth) stage.style.setProperty('--chrome-w', book.offsetWidth + 'px');
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

    var flipped = id === 'toolbar' || id === 'lock' || id === 'studio';
    if (book) { book.classList.toggle('is-flipped', flipped); setCount(book, flipped ? '4–5' : '2–3'); }
    if (rtlBook) { rtlBook.classList.remove('is-flipped'); setCount(rtlBook, '2–3'); }
    site.classList.toggle('is-locked', id === 'lock');
    $$('.tour-stage').forEach(function (st) { st.classList.remove('is-rail'); });
    $$('[data-fx="grid"],[data-fx="more"]').forEach(function (b) { b.classList.remove('is-on', 'is-open'); });
    site.classList.toggle('is-studio', id === 'studio');
    site.style.removeProperty('--studio-bg');

    // Pro settings
    $$('.tour-radio').forEach(function (r, k) { r.classList.toggle('is-sel', k === 0); });
    $$('.tour-toggle').forEach(function (t) {
      t.classList.toggle('is-on', t.getAttribute('data-toggle') !== 'autoplay');
    });
    var skin = $('[data-skin]');
    if (skin) {
      if (!skin.hasAttribute('data-skin-orig')) skin.setAttribute('data-skin-orig', skin.textContent);
      skin.classList.remove('is-changed');
      skin.textContent = skin.getAttribute('data-skin-orig');
    }
    var lic = $('.tour-license'), key = $('[data-key]');
    if (lic) { lic.classList.remove('is-active'); key.textContent = ''; $('[data-activate]').classList.remove('is-pressed'); }
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
      var el = $('[data-type]');
      later(function () { type(el, el.getAttribute('data-type'), 55); }, 600);
    } else if (id === 'flip' || id === 'rtl') {
      var book = $(id === 'flip' ? '.tour-book--ltr' : '.tour-book--rtl');
      later(function () { book.classList.add('is-flipped'); }, 1000);
      later(function () { setCount(book, '4–5'); }, 2100);
    } else if (id === 'layouts') {
      var cards = $$('.tour-layout'), k = 0;
      every(function () { k = (k + 1) % cards.length; cards.forEach(function (c, j) { c.classList.toggle('is-sel', j === k); }); }, 950);
    } else if (id === 'toolbar') {
      var st = screen('site').querySelector('.tour-stage');
      later(function () { st.querySelector('[data-fx="grid"]').classList.add('is-on'); }, 700);
      later(function () { st.classList.add('is-rail'); }, 950);
    } else if (id === 'lock') {
      later(function () { var m = screen('site').querySelector('[data-fx="more"]'); m.classList.add('is-on', 'is-open'); }, 1100);
    } else if (id === 'protect') {
      var radios = $$('.tour-radio');
      later(function () { radios.forEach(function (r, j) { r.classList.toggle('is-sel', j === 1); }); }, 1300);
      later(function () { radios.forEach(function (r, j) { r.classList.toggle('is-sel', j === 2); }); }, 2700);
    } else if (id === 'viewer') {
      var tg = function (name) { return $('.tour-toggle[data-toggle="' + name + '"]'); };
      later(function () { tg('download').classList.remove('is-on'); }, 1100);
      later(function () { tg('print').classList.remove('is-on'); }, 1800);
      later(function () { var sk = $('[data-skin]'); sk.textContent = sk.getAttribute('data-skin-to'); sk.classList.add('is-changed'); }, 2700);
    } else if (id === 'studio') {
      var siteEl = screen('site'), colors = ['#efe9fb', '#e6f0ff', '#fdf0f5', '#eef7ee'], c = 0;
      every(function () { c = (c + 1) % colors.length; siteEl.style.setProperty('--studio-bg', colors[c]); }, 1100);
    } else if (id === 'license') {
      var licEl = $('.tour-license'), keyEl = $('[data-key]'), btn = $('[data-activate]');
      later(function () {
        type(keyEl, keyEl.getAttribute('data-key'), 36, function () {
          later(function () { btn.classList.add('is-pressed'); }, 300);
          later(function () { btn.classList.remove('is-pressed'); licEl.classList.add('is-active'); }, 600);
        });
      }, 500);
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
