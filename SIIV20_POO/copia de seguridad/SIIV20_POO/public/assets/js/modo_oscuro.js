document.getElementById("toggle-theme").onclick = function() {
    const body = document.body;
    const isDarkMode = body.classList.contains("bg-dark");
    const icono = document.getElementById("iconoModo");
    const tabla = document.getElementById("dataTable");
    const modalContents = document.querySelectorAll(".modal-content-theme");

    // Cambiar el tema del fondo y texto en el cuerpo de la página
    body.classList.toggle("bg-dark", !isDarkMode);
    body.classList.toggle("text-light", !isDarkMode);
    body.classList.toggle("bg-light", isDarkMode);
    body.classList.toggle("text-dark", isDarkMode);

    // Cambiar el icono
    if (isDarkMode) {
        icono.classList.remove("bi-moon");
        icono.classList.add("bi-brightness-high");
    } else {
        icono.classList.remove("bi-brightness-high");
        icono.classList.add("bi-moon");
    }

    // Cambiar el tema de la tabla
    tabla.classList.toggle("table-dark", !isDarkMode);
    tabla.classList.toggle("table-light", isDarkMode);

    // Cambiar el tema de todos los modales con la clase 'modal-content-theme'
    modalContents.forEach(modalContent => {
        modalContent.classList.toggle("bg-dark", !isDarkMode);
        modalContent.classList.toggle("text-light", !isDarkMode);
        modalContent.classList.toggle("bg-light", isDarkMode);
        modalContent.classList.toggle("text-dark", isDarkMode);
    });
};


(function() {
    "use strict";
  
    /**
     * Easy selector helper function
     */
    const select = (el, all = false) => {
      el = el.trim()
      if (all) {
        return [...document.querySelectorAll(el)]
      } else {
        return document.querySelector(el)
      }
    }
  
    /**
     * Easy event listener function
     */
    const on = (type, el, listener, all = false) => {
      let selectEl = select(el, all)
      if (selectEl) {
        if (all) {
          selectEl.forEach(e => e.addEventListener(type, listener))
        } else {
          selectEl.addEventListener(type, listener)
        }
      }
    }
  
    /**
     * Easy on scroll event listener 
     */
    const onscroll = (el, listener) => {
      el.addEventListener('scroll', listener)
    }
  
    /**
     * Navbar links active state on scroll
     */
    let navbarlinks = select('#navbar .scrollto', true)
    const navbarlinksActive = () => {
      let position = window.scrollY + 200
      navbarlinks.forEach(navbarlink => {
        if (!navbarlink.hash) return
        let section = select(navbarlink.hash)
        if (!section) return
        if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
          navbarlink.classList.add('active')
        } else {
          navbarlink.classList.remove('active')
        }
      })
    }
    window.addEventListener('load', navbarlinksActive)
    onscroll(document, navbarlinksActive)
  
    /**
     * Scrolls to an element with header offset
     */
    const scrollto = (el) => {
      let header = select('#header')
      let offset = header.offsetHeight
  
      if (!header.classList.contains('header-scrolled')) {
        offset -= 16
      }
  
      let elementPos = select(el).offsetTop
      window.scrollTo({
        top: elementPos - offset,
        behavior: 'smooth'
      })
    }
  
    /**
     * Header fixed top on scroll
     */
    let selectHeader = select('#header')
    if (selectHeader) {
      let headerOffset = selectHeader.offsetTop
      let nextElement = selectHeader.nextElementSibling
      const headerFixed = () => {
        if ((headerOffset - window.scrollY) <= 0) {
          selectHeader.classList.add('fixed-top')
          nextElement.classList.add('scrolled-offset')
        } else {
          selectHeader.classList.remove('fixed-top')
          nextElement.classList.remove('scrolled-offset')
        }
      }
      window.addEventListener('load', headerFixed)
      onscroll(document, headerFixed)
    }
  
    /**
     * Back to top button
     */
    let backtotop = select('.back-to-top')
    if (backtotop) {
      const toggleBacktotop = () => {
        if (window.scrollY > 100) {
          backtotop.classList.add('active')
        } else {
          backtotop.classList.remove('active')
        }
      }
      window.addEventListener('load', toggleBacktotop)
      onscroll(document, toggleBacktotop)
    }
  
    /**
     * Mobile nav toggle
     */
    on('click', '.mobile-nav-toggle', function(e) {
      select('#navbar').classList.toggle('navbar-mobile')
      this.classList.toggle('bi-list')
      this.classList.toggle('bi-x')
    })
  
    /**
     * Mobile nav dropdowns activate
     */
    on('click', '.navbar .dropdown > a', function(e) {
      if (select('#navbar').classList.contains('navbar-mobile')) {
        e.preventDefault()
        this.nextElementSibling.classList.toggle('dropdown-active')
      }
    }, true)
  
    /**
     * Preloader
     */
    let preloader = select('#preloader');
    if (preloader) {
      window.addEventListener('load', () => {
        preloader.remove()
      });
    }
  
  })()
  
  
  


