<x-utils.box color="gray" class="w-full text-sm">
    <b class="font-bold">Prix total</b>
    <div class="flex">
        <div class="flex-1">Prix de base</div>
        <div class="self-end" x-text="total.base.toEuro()">-</div>
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
    <div class="flex mt-2">
        <div class="flex-1 font-bold">Prix total</div>
        <div class="self-end font-bold" x-text="total.total.toEuro()">-</div>
    </div>
</x-utils.box>
