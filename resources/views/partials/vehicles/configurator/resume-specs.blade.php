<div>
    <div class="mb-2 font-bold" x-text="version?.versionName ?? ''"></div>
    <x-utils.label x-text="version?.fuelType" class="uppercase" x-show="version?.fuelType != ''">-</x-utils.label>
    <x-utils.label x-text="version?.gearboxType" class="uppercase" x-show="version?.gearboxType != ''">-</x-utils.label>
    <x-utils.label x-text="version?.traction" class="uppercase" x-show="version?.traction != ''">-</x-utils.label>
    <ul class="flex flex-col my-4 text-xs cursor-default gap-y-2 gap-x-1 specs-list">
        <li class=" hover:bg-gray-200 hover:outline-4 outline-gray-200">
            <span>Puissance</span>
            <span class="dots"></span>
            <span class="font-normal"><span x-text="version?.engine.HP ?? '-'">-</span> <small>HP</small> / <span x-text="version?.engine.kw ?? '-'">-</span> <small>CV</small></span>
        </li>
        <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
            <span>Émissions de CO2</span>
            <span class="dots"></span>
            <span class="font-normal"><span x-text="version?.omologation.emissions.combined ?? '-'">-</span> <small>g/Km</small></span>
        </li>
        <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
            <span>Cylindrée</span>
            <span class="dots"></span>
            <span class="font-normal"><span x-text="version?.engine.cm3 ?? '-'">-</span> <small>cm3</small></span>
        </li>
        <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
            <span>Cons. de carburant mixte</span>
            <span class="dots"></span>
            <span class="font-normal"><span x-text="version?.omologation.consumption.combined ?? '-'">-</span> <small>l/100km</small></span>
        </li>
        <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
            <span>Autonomie</span>
            <span class="dots"></span>
            <span class="font-normal"><span x-text="version?.battery.autonomy ?? version?.omologation.range.combined ?? '-'">-</span> <small>Km</small></span>
        </li>
        <li class="hover:bg-gray-200 hover:outline-4 outline-gray-200">
            <span>Cons. électrique mixte</span>
            <span class="dots"></span>
            <span class="font-normal"><span x-text="version?.omologation.electricConsumption.combined ?? '-'">-</span> <small>kWh/100km</small></span>
        </li>
    </ul>
</div>
