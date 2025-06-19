<x-layouts.app :title="'Elements'">



    <div class="max-w-screen-xl px-4 py-4 mx-auto md:py-6">

        <h1 class="h1">Elements</h1>
        <p>All elements.</p>

        <div class="mt-2"><b>Samples range</b></div>

        <x-forms.elements.range
        name="inp_"
        min="0"
        max="100000"
        min-value="5000"
        max-value="95000"
        step="5000"
        label="Votre budget"/>

        <x-forms.elements.range
        name="inp_"
        min="0"
        max="300000"
        min-value="5000"
        max-value="200000"
        step="5000"
        prefix="km"
        class="mt-4"
        />

        <div class="mt-8"><b>Checkbox</b></div>

        <x-forms.elements.checkbox class="inline-block mt-4" name="inp_checkbox_simple" label="Simple checkbox"/>

        <x-forms.elements.checkbox class="inline-block mt-4" name="inp_checkbox_disabled" label="Disabled checkbox" disabled/>

        <x-forms.elements.checkbox class="inline-block mt-4" name="inp_checkbox_checked" label="Checked checkbox" checked/>

        <x-forms.elements.checkbox class="inline-block mt-4" name="inp_checkbox_small" label="Small checkbox" size="sm"/>

        <div class="mt-8"><b>Radio</b></div>

        <x-forms.elements.radio class="inline-block mt-4" name="inp_radio" label="Simple radio" value="1" checked/>
        <x-forms.elements.radio class="inline-block mt-4" name="inp_radio" label="Simple radio" value="2"/>

        <div class="mt-8"><b>Select</b></div>

        <x-forms.elements.select class="mt-4" :options="
        array(
            array( 'value' => '1', 'name' => 'Option <b>1</b>' ),
            array( 'value' => '2', 'name' => 'Option <b>2</b>' ),
            array( 'value' => '3', 'name' => 'Option <b>3</b>' ),
            array( 'value' => '4', 'name' => 'Option <b>4</b>' ),
        )" name="inp_select_simple" placeholder="Simple select"/>

        <x-forms.elements.select class="mt-4" multiple :options="
        array(
            array( 'value' => '1', 'name' => 'Option <b>1</b>' ),
            array( 'value' => '2', 'name' => 'Option <b>2</b>' ),
            array( 'value' => '3', 'name' => 'Option <b>3</b>' ),
            array( 'value' => '4', 'name' => 'Option <b>4</b>' ),
        )" name="inp_select_multi" placeholder="Multi select"/>

        <x-forms.elements.select class="mt-4" multiple :options="
        array(
            array( 'value' => '1', 'name' => 'Option <b>1</b>' ),
            array( 'value' => '2', 'name' => 'Option <b>2</b>' ),
            array( 'value' => '3', 'name' => 'Option <b>3</b>' ),
            array( 'value' => '4', 'name' => 'Option <b>4</b>' ),
        )" :values="array(3,2)" name="inp_select_pre" placeholder="Multi select with selected value"/>

        <div class="mt-8"><b>Buttons</b></div>

        <div>
            <x-utils.button class="mt-8" label="Default"></x-utils.button>
            <x-utils.button class="mt-8" label="Theme" color="theme"></x-utils.button>
            <x-utils.button class="mt-8" label="Theme 2" color="theme-2"></x-utils.button>
            <x-utils.button class="mt-8" label="Light" color="light"></x-utils.button>
            <x-utils.button class="mt-8" label="Dark" color="black"></x-utils.button>
            <x-utils.button class="mt-8" label="Button sm" size="sm"></x-utils.button>
            <x-utils.button class="mt-8" label="Button xs" size="xs"></x-utils.button>
        </div>
        <div>
            <x-utils.button class="mt-8" label="Default (icon)" icon="icon-search"></x-utils.button>
            <x-utils.button class="mt-8" label="Default (r-icon)" color="light" r-icon="icon-chevron-right"></x-utils.button>
            <x-utils.button class="mt-8" label="Default (r-icon)" color="black" icon="icon-envelope" r-icon="icon-chevron-right" size="xs"></x-utils.button>
            <x-utils.button class="mt-8" label="Label filtred" color="black" r-icon="icon-times" size="xs"></x-utils.button>
        </div>

        {{-- <input type="radio" class="my-2 mr-2" name="radio" id="option1" value="1" checked>
        <label class="mr-8 cursor-pointer select-none" for="option1">Option 1</label>

        <input type="radio" class="my-2 mr-2" name="radio" id="option2" value="2" checked>
        <label class="mr-8 cursor-pointer select-none" for="option2">Option 2</label>

        <div style="font-size:0.8em;">
            <input type="radio" class="my-2 mr-2" name="radio" id="option-small" value="2" checked>
            <label class="mr-8 cursor-pointer select-none" for="option2">Option small</label>
        </div> --}}

    </div>

</x-layouts.app>
