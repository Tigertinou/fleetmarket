<div {{ $attributes->merge(['class' => '']) }}>

    <div class="flex flex-col max-w-sm mx-auto">

        <div>
            <div class="text-sm font-extrabold text-center">Votre budget</div>
            <x-forms.elements.range
                name="inp_price"
                min="0"
                max="100000"
                min-value="5000"
                max-value="95000"
                step="1000"/>
        </div>

        <div class="mt-4">
            <div class="mb-2 text-sm font-extrabold">Carosseries</div>
            <x-forms.elements.select id="bodytype-select" multiple :options="[]" name="inp_bodytype" placeholder="Type de carosserie ..."/>
        </div>

        <div class="mt-4">
            <div class="mb-2 text-sm font-extrabold">Marques</div>
            <x-forms.elements.select id="brands-select" multiple :options="[]" name="inp_brands" placeholder="Marques ..."/>
        </div>

        <x-utils.button label="Rechercher" icon="icon-search" class="w-full mt-4" size="lg"></x-utils.button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {

        window.api.motork.getMakes().then(function (makes) {
            const list = document.querySelector('#brands-select .select-list');
            if(list!=null){
                makes.forEach(item => {
                    let div = document.createElement('div');
                    div.setAttribute('class', 'px-3 border-b border-gray-100 active:bg-gray-50 hover:bg-gray-50 text-xs');
                    div.innerHTML = `<div class="flex items-center checkbox">
                        <input type="checkbox" id="id-make-${ item.id }" name="inp_make" value="${ item.id }" data-label="${ item.name.toUpperCase() }" @change="change">
                        <label class="flex items-center flex-1 py-2 pl-3 mr-8 font-extrabold uppercase cursor-pointer select-none" for="id-make-${ item.id }">
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

        window.api.motork.getFacets('bodyType').then(function (types) {
            const list = document.querySelector('#bodytype-select .select-list');
            if(list!=null){
                types.forEach(item => {
                    let div = document.createElement('div');
                    div.setAttribute('class', 'px-3 border-b border-gray-100 active:bg-gray-50 hover:bg-gray-50 text-xs');
                    div.innerHTML = `<div class="flex items-center checkbox">
                        <input type="checkbox" id="id-bodytype-${ item.value }" name="inp_bodytype" value="${ item.value }" data-label="${ item.label.fr.toUpperCase() }" @change="change">
                        <label class="flex items-center flex-1 py-2 pl-3 mr-8 font-extrabold uppercase cursor-pointer select-none" for="id-bodytype-${ item.value }">
                            <b>${ item.label.fr.toUpperCase() }</b>
                        </label>
                    </div>`;
                    list.appendChild(div);
                    Alpine.initTree(div);
                });
            }
        }).catch(function (error) {
            console.error('Error fetching facets:', error);
        });

    });
</script>
