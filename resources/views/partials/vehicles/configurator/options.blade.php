<div id="options-list" x-data="{
    showStandard: true,
    options: [],
 }">
    <template x-for="(eqSection, eqSectionKey) in options" :key="eqSectionKey">
        <details>
            <summary class="pl-4 -ml-4 font-bold text-gray-800" x-text="eqSectionKey"></summary>
            <div class="pl-2 mt-2">
                <template x-for="(eqSubSection, eqSubSectionKey) in eqSection" :key="eqSubSectionKey">
                    <div class="mb-4">
                        <div class="text-sm font-semibold " x-text="eqSubSectionKey"></div>
                        <div class="flex flex-col gap-3 mt-4">
                            <template x-for="equipment in eqSubSection" :key="equipment.idEquipment">

                                <div class="flex items-start flex-1 gap-2 text-sm" x-show="showStandard || equipment.type != 'STANDARD'">
                                    <input type="checkbox" name="inp_equipments" :id="'id-equipments-' + equipment.idEquipment" :value="equipment.idEquipment" style="font-size:1em;" :disabled="equipment.type=='STANDARD'">
                                    <label class="flex-1 mr-8 align-middle cursor-pointer select-none" :for="'id-equipments-' + equipment.idEquipment" x-text="equipment.description"></label>
                                </div>

                                    {{-- <x-forms.elements.checkbox class="inline-block" name="inp_equipments" x-value="equipment.idEquipment"><span x-text="equipment.description"></span></x-forms.elements.checkbox> --}}
                                    {{-- <div><strong>ID:</strong> <span x-text="equipment.idEquipment"></span></div>
                                    <div><strong>Description:</strong> <span x-text="equipment.description"></span></div> --}}

                            </template>
                        </div>
                    </div>
                </template>
            </div>
        </details>
    </template>

    {{-- <template x-for="(section, sectionKey) in options">
        <li>
            <span x-text="sectionKey"></span>
            <ul>
                <template x-for="(subSection, subSectionKey) in section">
                    <li x-text="subSectionKey">
                        <ul>
                            <template x-for="(equipment, equipmentKey) in subSection">
                                <li x-text="equipment.description"></li>
                            </template>
                        </ul>
                    </li>
                </template>
            </ul>
        </li>
    </template> --}}
    {{-- <div class="flex flex-col gap-4">
        <div class="flex flex-col gap-2">
            <label for="options-select" class="text-sm font-semibold">Select Options</label>
            <select id="options-select" x-model="selectedOption" class="form-select">
                <option value="">-- Select an option --</option>
                <template x-for="option in options" :key="option.id">
                    <option :value="option.id" x-text="option.name"></option>
                </template>
            </select>
        </div>

        <button @click="addOption()" class="btn btn-primary">Add Option</button>

        <div class="mt-4">
            <h4 class="text-lg font-semibold">Selected Options</h4>
            <ul>
                <template x-for="option in selectedOptions" :key="option.id">
                    <li x-text="option.name"></li>
                </template>
            </ul>
        </div>
    </div> --}}
</div>
