<div>
    <div class="mb-2 font-bold" x-text="version?.versionName ?? ''"></div>
    <x-utils.label x-text="version?.fuelType" class="uppercase" x-show="version?.fuelType != ''">-</x-utils.label>
    <x-utils.label x-text="version?.gearboxType" class="uppercase" x-show="version?.gearboxType != ''">-</x-utils.label>
    <x-utils.label x-text="version?.traction" class="uppercase" x-show="version?.traction != ''">-</x-utils.label>
    <ul class="flex flex-col my-4 text-xs cursor-default gap-y-2 gap-x-1 specs-list">
        <li class=" hover:bg-gray-200 hover:outline-4 outline-gray-200">
            <span>{{ __tl('Puissance') }}</span>
            <span class="dots"></span>
            <span class="font-normal"><span x-text="version?.engine.HP ?? '-'">-</span> <small>{{ __tl('HP') }}</small> / <span x-text="version?.engine.kw ?? '-'">-</span> <small>{{ __tl('CV') }}</small></span>
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
</div>
