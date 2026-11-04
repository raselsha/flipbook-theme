(function(){
  document.documentElement.classList.add('html-has-js');

  var toggle = document.querySelector('.nav-toggle');
  var header = document.querySelector('.site-header');
  if (toggle && header) {
    toggle.addEventListener('click', function(){
      header.classList.toggle('is-open');
    });
  }

  // "Demo" is only a submenu label — keep its "#" from jumping to the top.
  document.querySelectorAll('.nav-has-sub > a[href="#"]').forEach(function(link){
    link.addEventListener('click', function(e){ e.preventDefault(); });
  });

  document.querySelectorAll('.copy-btn[data-copy]').forEach(function(btn){
    btn.addEventListener('click', function(){
      if (!navigator.clipboard) return;
      navigator.clipboard.writeText(btn.getAttribute('data-copy')).then(function(){
        var label = btn.textContent;
        btn.textContent = 'Copied';
        setTimeout(function(){ btn.textContent = label; }, 1600);
      });
    });
  });

  var prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  var targets = document.querySelectorAll('.reveal');
  if (!targets.length) return;

  if (prefersReduced || !('IntersectionObserver' in window)) {
    targets.forEach(function(el){ el.classList.add('is-visible'); });
    return;
  }

  var io = new IntersectionObserver(function(entries){
    entries.forEach(function(entry){
      if (entry.isIntersecting) {
        entry.target.classList.add('is-visible');
        io.unobserve(entry.target);
      }
    });
  }, { threshold: 0.15 });

  targets.forEach(function(el){ io.observe(el); });
})();
