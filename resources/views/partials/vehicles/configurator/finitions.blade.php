<div id="select-finition" class="flex flex-col gap-3 mt-4 select-none" x-data="{
    change(target){
        $el.querySelectorAll('[type=radio]').forEach( (el) => {
            const data = Alpine.$data(el).active = (el==target);
        });
    },
    select(target){
        const radio = target.closest('.box').querySelector('[type=radio]');
        if(radio!=null){
            radio.click();
            finitionSelected = radio.value;
            motorSelected = radio.closest('[data-motor]').dataset.motor;
            Alpine.$data(document.getElementById('select-motor')).init();
        }
    },
    init () {
        $el.querySelectorAll('[type=radio]').forEach( (el) => {
            if(el.value == finitionSelected){
                this.select(el);
            }
        });
    }}">
    @foreach ($finitions as $finition)
        <x-utils.box x-data="{active : ( finitionSelected == '{{ $finition['trimCode'] }}' )}" x-bind:class="active ? 'border-theme' : 'border-gray-200'" color="bordered" class="flex-1 w-full cursor-pointer hover:outline-2 hover:border-white hover:outline-theme" @click="select($event.target)">
            <div class="flex gap-3">
                <x-forms.elements.radio name="inp_finition" value="{{ $finition['trimCode'] }}" data-motor="{{ $finition['versionUrlCode'] }}" @change="change($event.target)" size="md" class="pt-0.5 -ml-2 "/>
                <div class="flex w-full gap-1 leading-5 justify-stretch">
                    <div class="flex-1">
                        <b class="font-semibold uppercase">{{ $finition['trimName'] }}</b>
                        <br><small><b class="uppercase">{{ implode(' / ',$finition['fuelTypes'])}}</b></small>
                    </div>
                    <div class="justify-end text-right">
                        <span class="flex-1 text-xs whitespace-nowrap">à partir de</span><br>
                        <span class="text-xs whitespace-nowrap"><span class="text-base font-extrabold md:text-base">{{ number_format($finition['price'], 0, ',', '.') . ' €' }}</span></span>
                    </div>
                </div>
            </div>
        </x-utils.box>
    @endforeach
</div>
