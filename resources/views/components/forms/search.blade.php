<div {{ $attributes->merge(['class' => '']) }}>

    <x-forms.elements.range
        name="inp_"
        min="0"
        max="100000"
        min-value="5000"
        max-value="95000"
        step="5000"
        label="Votre budget"/>

    <x-forms.elements.select id="brands-select" class="mt-4" multiple :options="[]" name="inp_brands" placeholder="Select your brand ..."/>

</div>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        window.api.motork.getMakes().then(function (makes) {
            const list = document.querySelector('#brands-select .select-list');
            if(list!=null){
                makes.forEach(item => {
                    console.log(item);
                    let div = document.createElement('div');
                    div.setAttribute('class', 'px-3 border-b border-gray-100 active:bg-gray-50 hover:bg-gray-50');
                    div.innerHTML = `<div class="flex py-2 checkbox">
                        <input type="checkbox" class="mr-2" id="id-make-${ item.id }" name="make" value="${ item.id }" data-label="${ item.name }">
                        <label class="flex-1 mr-8 cursor-pointer select-none" for="id-make-${ item.id }">${ item.name }</label>
                    </div>`;
                    list.appendChild(div);
                });
            }
            /* console.log(makes); */
        }).catch(function (error) {
            console.error('Error fetching makes:', error);
        });
    });
</script>
