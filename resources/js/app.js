// import './bootstrap';
import '../css/app.css';
import RangeSlider from './components/RangeSlider';
import Swipe from './components/Swipe';
import MotorkApi from './api/MotorkApi';

window.api = {
    motork : new MotorkApi()
};

window.unavailable = function(){
    alert('Bientôt disponible!')
}

window.changeLang = function(lang){
    if (lang === window.lang) return;
    const currentUrl = window.location.pathname;
    const newUrl = currentUrl.replace(/\/(fr|nl)\//, `/${lang}/`);
    window.location.href = newUrl;
}

window.dataMove = function(){
    if (window.innerWidth < 768) {
        document.querySelectorAll('[data-move-desktop]:not(.moved)').forEach(function (el) {
            const target = document.querySelector('[data-move-mobile="' + el.dataset.moveDesktop + '"]');
            if (target) {
                while (el.firstChild) {
                    target.appendChild(el.firstChild);
                }
            }
            el.classList.add('moved');
        });
        document.querySelectorAll('[data-move-mobile]').forEach(function (el) {
            el.classList.remove('moved');
        });
    } else {
        document.querySelectorAll('[data-move-mobile]:not(.moved)').forEach(function (el) {
            const target = document.querySelector('[data-move-desktop="' + el.dataset.moveMobile + '"]');
            if (target) {
                while (el.firstChild) {
                    target.appendChild(el.firstChild);
                }
            }
            el.classList.add('moved');
        });
        document.querySelectorAll('[data-move-desktop]').forEach(function (el) {
            el.classList.remove('moved');
        });
    }
}

document.addEventListener("DOMContentLoaded", function () {

    /********************** DATAMOVE **********************/
    window.dataMove();
    window.addEventListener('resize', function () {
        window.dataMove();
    });

    /********************** TABS **********************/
    document.addEventListener('scroll', function () {
        window.active_tab = window.active_tab || Alpine.$data(document.getElementById('main')).activeTab;
        var tab = window.active_tab;
        var offset = document.getElementById('tabs').getBoundingClientRect().top + document.getElementById('tabs').getBoundingClientRect().height + 50;
        if(offset==null){
            offset = (window.innerHeight || document.documentElement.clientHeight) * 0.5;
        }
        document.querySelectorAll('[data-enter-tab]').forEach( (el) => {
            const rect = el.getBoundingClientRect();
            if (rect.top < offset) {
                tab = el.getAttribute('data-enter-tab');
            }
        });
        if(tab != window.active_tab) {
            window.active_tab = tab;
            Alpine.$data(document.getElementById('main')).activeTab = tab;
            document.querySelectorAll('[data-tab="'+tab+'"]')[0].scrollIntoView({
                behavior: 'smooth',
                inline: 'center',
                block: 'nearest'
            });
        }
    });
    document.querySelectorAll('[data-tab]').forEach( (el) => {
        el.addEventListener('click', () => {
            var offset = document.getElementById('tabs').getBoundingClientRect().top + document.getElementById('tabs').getBoundingClientRect().height;
            scrollTo({
                top: document.querySelectorAll(`[data-enter-tab="${el.dataset.tab}"]`)[0].offsetTop - offset,
                behavior: 'smooth'
            });
            window.active_tab = el.getAttribute('data-tab');
            Alpine.$data(document.getElementById('main')).activeTab = window.active_tab;
        });
    },{ once: true });
});
