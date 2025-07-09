// import './bootstrap';
import '../css/app.css';
import RangeSlider from './components/RangeSlider';
import Swipe from './components/Swipe';
import MotorkApi from './api/MotorkApi';

window.api = {
    motork : new MotorkApi()
};

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
    window.dataMove();
    window.addEventListener('resize', function () {
        window.dataMove();
    });
});
