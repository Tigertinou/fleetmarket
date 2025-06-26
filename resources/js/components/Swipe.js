
export default class Swipe {
    constructor(el){
        this.el = el;
        this.items = this.el.querySelectorAll('.swipe-item');
        this.el.addEventListener('wheel', () => { console.log('user is interacting'); }, { passive: true });
        this.el.addEventListener('touchstart', () => { console.log('user is interacting'); }, { passive: true });
        this.el.addEventListener('mouseenter', () => { console.log('mouseenter'); this.isHovered = true; });
        this.el.addEventListener('mouseleave', () => { console.log('mouseleave'); this.isHovered = false; });
    }
}
/*** checksize ***/
/* window.addEventListener('checksize',function(e){
    var w = window.innerWidth||e.clientWidth||_('body')[0].clientWidth;
    var d = '';
    var s = '';
    if(w>=1200){ d='xl';s='desktop'; } else if(w>=992){ d='lg';s='desktop'; } else if(w>=768){ d='md';s='tab'; } else if(w>=576){ d='sm';s='mobile'; } else if(w<576&&w>0){ d='xs';s='mobile'; }
    window.mmdevice = {type:s,size:d};
});
window.dispatchEvent(new Event('checksize'));
window.addEventListener('resize',function(e){
    window.dispatchEvent(new Event('checksize'));
});


export default class Swipe {
    constructor(el){
        this.el = el;
        this.el.swipe = this;
        this.col = 2;
        this.el.classList.remove('list','mm-row');
        if(parseFloat(this.el.getAttribute('data-swipe-'+window.mmdevice.type))>0){
            this.col = parseFloat(this.el.getAttribute('data-swipe-'+window.mmdevice.type));
            this.el.setAttribute('data-swipe-col',this.col);
        }
        if(this.el.querySelectorAll('.swipe-slides').length==0){
            this.container = document.createElement('div');
            this.container.classList.add('swipe-slides');
            this.el.slides = document.createElement('ul');
            this.container.appendChild(this.el.slides);
            this.el.querySelectorAll('.webblock').forEach(wb => {
                var li = document.createElement('li');
                li.style.flexBasis = (((this.el.offsetWidth-60)/this.col))+"px";
                var div = document.createElement('div');
                div.style.padding = "1em 1em 0 1em";
                div.appendChild(wb);
                li.appendChild(div);
                this.el.slides.appendChild(li);
            });
            this.el.innerHTML = "";
            this.el.appendChild(this.container);
        } else {
            this.el.slides = this.el.querySelectorAll('.swipe-slides ul')[0];
        }

        let scrollTimeout;
        this.container.addEventListener('scroll', () => {
            clearTimeout(scrollTimeout);
            if(window.visible_pic!=null){
                scrollTimeout = setTimeout(() => window.visible_pic(), 300);
            }
        }, { passive: true });

        if(el.getAttribute('data-swipe-randomize')==1){
            el.querySelectorAll('li').forEach(li => {
                li.style.order = Math.floor(Math.random() * 100);
            });
        }

        if(window.mmdevice.type!='mobile'){
            var back = document.createElement('button');
            back.classList.add('back');
            back.innerHTML = '<i class="fas fa-arrow-left d-block"></i>';
            back.addEventListener('click',() => this.swipe_slide('back',true));
            this.el.appendChild(back);

            var next = document.createElement('button');
            next.classList.add('next');
            next.innerHTML = '<i class="fas fa-arrow-right d-block"></i>';
            next.addEventListener('click',() => this.swipe_slide('next',true));
            this.el.appendChild(next);
        }

        if(this.el.getAttribute('data-swipe-auto')==1){
            this.initAutoInterval = () => {
                this.autoInterval = setInterval(() => {
                    if(!this.isHovered) this.swipe_slide('next');
                },3000);
            };
            (new IntersectionObserver((entries) => {
                entries.forEach((entry) => {
                    if (entry.isIntersecting) {
                        this.initAutoInterval();
                    } else {
                        if(this.autoInterval) clearInterval(this.autoInterval);
                    }
                });
            }, { threshold: 1 })).observe(this.el);
        }
        this.container.addEventListener('wheel', () => { clearInterval(this.autoInterval); console.log('user is interacting'); }, { passive: true });
        this.container.addEventListener('touchstart', () => { clearInterval(this.autoInterval); console.log('user is interacting'); }, { passive: true });
        this.el.addEventListener('mouseenter', () => { this.isHovered = true; });
        this.el.addEventListener('mouseleave', () => { this.isHovered = false; });
        if(this.el.slides.childElementCount>0){ this.el.classList.add('loaded'); }

    }
    swipe_slide(dir,stopAutoInterval){
        if(this.container.querySelector("li")===null) return;
        var slideWidth = this.container.querySelector("li").offsetWidth;
        if(this.container.scrollLeft + this.container.clientWidth >= this.container.scrollWidth - 2){
            this.container.scrollLeft = 0;
            return;
        }
        if(dir=='next') this.container.scrollBy({left: slideWidth, behavior: 'smooth'});
        if(dir=='back') this.container.scrollBy({left: -(slideWidth), behavior: 'smooth'});

        if(stopAutoInterval){
            clearInterval(this.autoInterval);
        }
        return;
    }
};
 */
document.querySelectorAll('.swipe').forEach(el => new Swipe(el) );
