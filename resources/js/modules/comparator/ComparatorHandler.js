export default class Comparator {
    constructor(el) {
        this.el = el;
        this.el.comparator = this;
        this.el.classList.add('comparator');
        this.el.innerHTML = '';
    }
}
