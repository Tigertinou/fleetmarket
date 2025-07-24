<div id="select-motor" class="flex flex-col gap-3 mt-4 select-none" x-data="{
    change(target){
        versionHistoricalId = target.closest('[data-versionHistoricalId]').getAttribute('data-versionHistoricalId');
        window.configurator.selectVersion(versionHistoricalId);
        $el.querySelectorAll('[type=radio]').forEach( (el) => {
            const data = Alpine.$data(el).active = (el==target);
        });
    },
    select(target){
        const radio = target.closest('.box').querySelector('[type=radio]');
        if(radio!=null){
            radio.click();
        }
    },
    init () {
        $el.querySelectorAll('[type=radio]').forEach( (el) => {
            if(el.value == motorSelected){
                this.select(el);
            }
        });
    }}">
    @foreach ($motors as $motor)
        <x-utils.box x-data="{active : ( motorSelected == '{{ $motor['versionUrlCode'] }}' )}" x-show="finitionSelected == '{{ $motor['trimCode'] }}'" x-bind:class="active ? 'border-theme' : 'border-gray-200'" color="bordered" class="flex-1 w-full cursor-pointer hover:outline-2 hover:border-white hover:outline-theme" data-versionHistoricalId="{{ $motor['versionHistoricalId'] }}" @click="select($event.target)">
            <div class="flex gap-3">
                <x-forms.elements.radio name="inp_motor" value="{{ $motor['versionUrlCode'] }}" @change="change($event.target)" size="md" class="pt-0.5 -ml-2 "/>
                <div class="flex w-full gap-1 leading-5 justify-stretch">
                    <div class="flex-1">
                        <b class="font-semibold">{{ $motor['versionName'] }}</b>
                        <br><small><b class="uppercase">{{ $motor['fuelType']}}</b> / <b class="uppercase">{{ $motor['gearboxType']}}</b> / <b class="uppercase">{{ $motor['traction']}}</b></small>
                    </div>
                    <div class="justify-end text-right">
                        <span class="flex-1 text-xs whitespace-nowrap">{{ __tl('à partir de') }}</span><br>
                        <span class="text-xs whitespace-nowrap"><span class="text-base font-extrabold md:text-base">{{ number_format($motor['price'], 0, ',', '.') . ' €' }}</span></span>
                    </div>
                </div>
            </div>
            <ul x-show="active" class="flex flex-col my-4 ml-6 text-xs cursor-default gap-y-1 gap-x-1 specs-list">
                <li class=" hover:bg-gray-200 hover:outline-4 outline-gray-200">
                    <span>{{ __tl('Puissance') }}</span>
                    <span class="dots"></span>
                    <span class="font-normal"><span x-text="version?.engine.HP ?? '-'">-</span> <small>{{ __tl('HP') }}</small> / <span x-text="version?.engine.kw ?? '-'">-</span> <small>CV</small></span>
                </li>
                <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200" x-show="version?.omologation.emissions.combined">
                    <span>{{ __tl('Émissions de CO2') }}</span>
                    <span class="dots"></span>
                    <span class="font-normal"><span x-text="version?.omologation.emissions.combined ?? '-'">-</span> <small>{{ __tl('g/Km') }}</small></span>
                </li>
                <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200" x-show="version?.engine.cm3">
                    <span>{{ __tl('Cylindrée') }}</span>
                    <span class="dots"></span>
                    <span class="font-normal"><span x-text="version?.engine.cm3 ?? '-'">-</span> <small>{{ __tl('cm3') }}</small></span>
                </li>
                <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200" x-show="version?.omologation.consumption.combined">
                    <span>{{ __tl('Cons. de carburant mixte') }}</span>
                    <span class="dots"></span>
                    <span class="font-normal"><span x-text="version?.omologation.consumption.combined ?? '-'">-</span> <small>{{ __tl('l/100km') }}</small></span>
                </li>
                <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200" x-show="version?.battery.autonomy ?? version?.omologation.range.combined">
                    <span>{{ __tl('Autonomie') }}</span>
                    <span class="dots"></span>
                    <span class="font-normal"><span x-text="version?.battery.autonomy ?? version?.omologation.range.combined ?? '-'">-</span> <small>{{ __tl('Km') }}</small></span>
                </li>
                <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200" x-show="version?.omologation.electricConsumption.combined">
                    <span>{{ __tl('Cons. électrique mixte') }}</span>
                    <span class="dots"></span>
                    <span class="font-normal"><span x-text="version?.omologation.electricConsumption.combined ?? '-'">-</span> <small>{{ __tl('kWh/100km') }}</small></span>
                </li>
            </ul>
        </x-utils.box>
    @endforeach
</div>
