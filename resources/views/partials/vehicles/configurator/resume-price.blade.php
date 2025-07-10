<x-utils.box color="gray" class="w-full text-sm">
    <b class="font-bold">Prix total</b>
    <div class="flex">
        <div class="flex-1">Prix de base</div>
        <div class="self-end" x-text="total.base.toEuro()">-</div>
    </div>
    <div class="flex flex-col gap-2 py-2 my-2 text-xs border-gray-400 border-dashed border-y" x-show="equipmentsSelected.length > 0">
        <template x-for="equipment in equipmentsSelected" :key="equipment.idEquipment">
            <div class="flex">
                <div class="flex-1" x-text="'+ ' + equipment.description"></div>
                <div class="self-end" x-text="'+ ' + equipment.msrp.toEuro()">-</div>
            </div>
        </template>
    </div>
    <div class="flex">
        <div class="flex-1">Total des options configurées</div>
        <div class="self-end" x-text="total.options.toEuro()">-</div>
    </div>
    <div class="flex">
        <div class="flex-1">Frais de livraison incluant la contribution environnementale pour le recyclage
            de la voiture</div>
        <div class="self-end" x-text="total.shipping.toEuro()">-</div>
    </div>
    <div class="flex items-center mt-2">
        <div class="flex-1 font-bold">Prix total</div>
        <div class="self-end text-lg font-bold" x-html="total.total.toEuro()">-</div>
    </div>
    <div><small>* Tous les prix affichés sont TTC</small></div>
</x-utils.box>
