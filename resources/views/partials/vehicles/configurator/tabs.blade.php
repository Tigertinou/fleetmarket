<div id="tabs" class="bg-white border-b border-gray-200">
    <div class="max-w-screen-xl mx-auto overflow-auto scrollbar-hide" style="-ms-overflow-style: none; scrollbar-width: none;">
        <div class="flex max-w-full gap-6 px-6 text-xs font-semibold cursor-pointer md:px-4 flex-nowrap">
            <div class="pt-6 pb-3 tab-item" data-tab="MODEL" :class="activeTab=='MODEL' ? 'border-b-4 border-theme' : ''">MODÈLE</div>
            <div class="pt-6 pb-3 tab-item" data-tab="FINITIONS" :class="activeTab=='FINITIONS' ? 'border-b-4 border-theme' : ''">FINITIONS</div>
            <div class="pt-6 pb-3 tab-item" data-tab="MOTORS" :class="activeTab=='MOTORS' ? 'border-b-4 border-theme' : ''">MOTEURS</div>
            <div class="pt-6 pb-3 tab-item" data-tab="EXTERNAL" :class="activeTab=='EXTERNAL' ? 'border-b-4 border-theme' : ''">EXTÉRIEUR</div>
            <div class="pt-6 pb-3 tab-item" data-tab="INTERIOR" :class="activeTab=='INTERIOR' ? 'border-b-4 border-theme' : ''">INTÉRIEUR</div>
            <div class="pt-6 pb-3 tab-item" data-tab="RIMS" :class="activeTab=='RIMS' ? 'border-b-4 border-theme' : ''">JANTES</div>
            <div class="pt-6 pb-3 tab-item" data-tab="PACKS" :class="activeTab=='PACKS' ? 'border-b-4 border-theme' : ''">PACKS</div>
            <div class="pt-6 pb-3 tab-item" data-tab="OPTINS" :class="activeTab=='OPTINS' ? 'border-b-4 border-theme' : ''">OPTIONS</div>
            <div class="pt-6 pb-3 tab-item" data-tab="ACCESSORIES" :class="activeTab=='ACCESSORIES' ? 'border-b-4 border-theme' : ''">ACCESSOIRES</div>
            <div class="pt-6 pb-3 tab-item" data-tab="RESUME" :class="activeTab=='RESUME' ? 'border-b-4 border-theme' : ''">RÉCAPITULATIF</div>
            <div>&nbsp;</div>
        </div>
    </div>
</div>
