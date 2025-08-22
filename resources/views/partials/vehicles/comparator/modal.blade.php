<script>
window.xDataComparatorModal = {
    init(){
        console.log('init');
        window.api.motork.getMakes().then(function (makes) {
            const list = document.querySelector('#makes-select .select-list');
            if(list!=null){
                makes.forEach(item => {
                    let div = document.createElement('div');
                    div.setAttribute('class', 'px-3 border-b border-gray-100 active:bg-gray-50 hover:bg-gray-50 text-sm');
                    div.innerHTML = `<div class="flex items-center checkbox">
                        <input type="radio" id="id-makes-${ item.slug }" name="inp_makes" value="${ item.slug }" data-label="${ item.name.toUpperCase() }" @change="change" style="display:none!important;">
                        <label class="flex items-center flex-1 py-2 pl-3 mr-8 font-extrabold uppercase cursor-pointer select-none" for="id-makes-${ item.slug }">
                            <span><img src="${ item.logo }" class="w-10 mr-2"></span>
                            <b>${ item.name.toUpperCase() }</b>
                        </label>
                    </div>`;
                    list.appendChild(div);
                    Alpine.initTree(div);
                });
            }
        }).catch(function (error) {
            console.error('Error fetching makes:', error);
        });
    }
}
</script>
<div x-data="window.xDataComparatorModal"></div>
<p>Choisissez la marque, le modèle et la version</p>

<x-forms.elements.select id="makes-select" :options="[]" name="inp_makes" placeholder="{{ __tl('Sélectionner la marque ...') }}"/>
