<div id="options-list" x-data="{
    showStandard: true,
    change (equipment,target) {
        Alpine.$data(target.closest('[x-data]')).checked = target.checked;
        if(target.checked){
            window.configurator.addEquipment(equipment);
        } else {
            window.configurator.removeEquipment(equipment);
        }
    },
    options: [],
 }">
    <x-forms.elements.switch class="flex-row-reverse mb-2 text-sm" name="inp_display_standard" label="Afficher l'équipement standard" value="1" size="sm" checked
    x-init="$watch(`toggled`, value => showStandard = value)"
    x-effect="toggled = showStandard"/>
    <template x-for="(eqSection, eqSectionKey) in options" :key="eqSectionKey">
        <details x-show="showStandard || Object.values(eqSection).some(sub => sub.some(e => e.type !== 'STANDARD'))">
            <summary class="pl-6 -ml-4 font-bold text-gray-800" x-text="eqSectionKey"></summary>
            <div class="pl-2 mt-2">
                <template x-for="(eqSubSection, eqSubSectionKey) in eqSection" :key="eqSubSectionKey">
                    <div class="mb-4" x-show="showStandard || eqSubSection.some(e => e.type !== 'STANDARD')">
                        <div class="text-sm font-semibold " x-text="eqSubSectionKey"></div>
                        <div class="flex flex-col gap-3 mt-4">
                            <template x-for="equipment in eqSubSection" :key="equipment.idEquipment">
                                <div x-data="{
                                    checked : (equipment.type=='STANDARD'),
                                    disabled : (equipment.type=='STANDARD')
                                }" class="flex items-start flex-1 gap-2 text-sm" x-show="showStandard || equipment.type != 'STANDARD'">
                                    <input type="checkbox" name="inp_equipments" :id="'id-equipments-' + equipment.idEquipment" :value="equipment.idEquipment" style="font-size:1em;" :disabled="disabled" :checked="checked" @change="change(equipment,event.target)" x-model="equipment.selected" class="form-checkbox" />
                                    <label class="flex flex-1 align-middle cursor-pointer select-none" :for="'id-equipments-' + equipment.idEquipment" >
                                        <span class="flex-1" x-text="equipment.description"></span>
                                        <span class="text-xs ">
                                            <span x-text="'+' + equipment.msrp.toEuro()" class="px-2 py-0.5 text-xs font-semibold rounded-lg border-1 " :class="(checked ? ( disabled ? 'border-gray-200' : 'border-2 border-theme') : 'border-gray-200') + ( equipment.msrp == 0 ? ' text-gray-300' : '')" ></span>
                                        </span>
                                    </label>
                                </div>
                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </details>
    </template>
</div>
