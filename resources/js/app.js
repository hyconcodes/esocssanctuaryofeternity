let deferredPrompt;
window.addEventListener('beforeinstallprompt', (e) => {
  e.preventDefault();
  deferredPrompt = e;
});

document.addEventListener('DOMContentLoaded', () => {
  const openBtn = document.getElementById('mobileMenuButton')
  const topNavMenu = document.getElementById('topNavMenu')
  if (openBtn && topNavMenu) {
    openBtn.addEventListener('click', () => {
      topNavMenu.classList.toggle('hidden')
    })
  }

  const mediaToggle = document.getElementById('mediaToggle')
  const mediaSubmenu = document.getElementById('mediaSubmenu')
  if (mediaToggle && mediaSubmenu) {
    mediaToggle.addEventListener('click', () => {
      mediaSubmenu.classList.toggle('hidden')
    })
  }

  const filters = document.querySelectorAll('[data-filter]')
  const items = document.querySelectorAll('[data-category]')
  filters.forEach((btn) => {
    btn.addEventListener('click', () => {
      const cat = btn.getAttribute('data-filter')
      items.forEach((el) => {
        const match = el.getAttribute('data-category') === cat
        el.classList.toggle('hidden', !match)
      })
    })
  })

  const lb = document.getElementById('lightbox')
  const lbImg = document.getElementById('lightboxImage')
  const lbClose = document.getElementById('lightboxClose')
  document.querySelectorAll('[data-lightbox]').forEach((img) => {
    img.addEventListener('click', () => {
      lbImg.src = img.getAttribute('data-lightbox') || img.src
      lb.classList.remove('hidden')
      lb.classList.add('flex')
    })
  })
  if (lbClose) {
    lbClose.addEventListener('click', () => {
      lb.classList.add('hidden')
      lb.classList.remove('flex')
      lbImg.src = ''
    })
  }

  const animEls = document.querySelectorAll('[data-animate]')
  animEls.forEach((el) => {
    el.classList.add('opacity-0', 'translate-y-4')
  })
  const io = new IntersectionObserver((entries) => {
    entries.forEach((entry) => {
      if (entry.isIntersecting) {
        entry.target.classList.remove('opacity-0', 'translate-y-4')
        entry.target.classList.add('transition', 'duration-500')
      }
    })
  }, { threshold: 0.15 })
  animEls.forEach((el) => io.observe(el))

  if ('serviceWorker' in navigator) {
    navigator.serviceWorker.register('/sw.js')
  }

document.querySelectorAll('[data-pwa-install]').forEach((btn) => {
    btn.addEventListener('click', async (ev) => {
      ev.preventDefault()
      if (deferredPrompt) {
        deferredPrompt.prompt()
        await deferredPrompt.userChoice
        deferredPrompt = null
      } else {
        const href = btn.getAttribute('href') || '/manifest.webmanifest'
        window.location.href = href
      }
    })
  })
})

window.addEventListener('load', () => {
  const pre = document.querySelector('[data-preloader]')
  if (pre) {
    pre.classList.add('opacity-0', 'pointer-events-none')
    setTimeout(() => pre.remove(), 500)
  }
})
