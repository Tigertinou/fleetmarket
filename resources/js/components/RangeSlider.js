export default class RangeSlider {
    constructor(el) {
        this.slider = el;
        console.log(el);
        this.step = parseInt(el.dataset.step || 1);
        this.min = parseInt(el.dataset.min || 0);
        this.max = parseInt(el.dataset.max);
        this.minValue = parseInt(el.dataset.minValue);
        this.maxValue = parseInt(el.dataset.maxValue);

        this.from = document.createElement('input');
        this.from.type = 'range';
        this.from.min = this.min;
        this.from.max = this.max;
        this.from.step = this.step;
        this.from.setAttribute('value',this.minValue);
        this.from.className = 'fromSlider';
        this.from.style.zIndex = 1;
        this.from.style.height = 0;

        this.to = document.createElement('input');
        this.to.type = 'range';
        this.to.min = this.min;
        this.to.max = this.max;
        this.to.step = this.step;
        this.to.setAttribute('value',this.maxValue);
        this.to.className = 'toSlider';

        this.controls = document.createElement('div');
        this.controls.classList.add('range-slider-control');
        this.controls.appendChild(this.from);
        this.controls.appendChild(this.to);

        this.slider.prepend(this.controls);

        // Initial fill
        this.fillSlider();

        // Events
        this.from.addEventListener('input', () => this.controlFromSlider());
        this.to.addEventListener('input', () => this.controlToSlider());

        this.change();
    }

    change() {
        this.slider.querySelectorAll('.text-min').forEach(el => {
            el.textContent = this.from.value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
        });
        this.slider.querySelectorAll('.text-max').forEach(el => {
            el.textContent = this.to.value.replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1 ');
        });
        this.slider.dispatchEvent(new CustomEvent('change', {
            detail: this.getParsed()
        }));
    }

    getParsed() {
        const from = parseInt(this.from.value, 10);
        const to = parseInt(this.to.value, 10);
        return [from, to];
    }

    fillSlider() {
        const [from, to] = this.getParsed();
        const range = this.max - this.min;
        const fromPos = ((from - this.min) / range) * 100;
        const toPos = ((to - this.min) / range) * 100;

        this.to.style.background = `linear-gradient(
            to right,
            #00000011 0%,
            #00000011 ${fromPos}%,
            var(--color-theme) ${fromPos}%,
            var(--color-theme) ${toPos}%,
            #00000011 ${toPos}%,
            #00000011 100%)`;
    }

    controlFromSlider() {
        let [from, to] = this.getParsed();
        if (from > to) {
            this.from.value = to;
        }
        this.change();
        this.fillSlider();
    }

    controlToSlider() {
        let [from, to] = this.getParsed();
        if (to < from) {
            this.to.value = from;
        }
        this.change();
        this.fillSlider();
    }
}
document.querySelectorAll('.range-slider').forEach(el => {
    el.rangeSlider = new RangeSlider(el);
});
