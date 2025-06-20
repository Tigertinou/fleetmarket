@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="icon icon-home font-thin text-xs" />', 'class' => 'font-semibold text-black'],
    ['label' => 'Elements']
]
@endphp
<x-layouts.app :title="'Elements'" :$breadcrumb>

    <x-utils.container>

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

        <div class="flex flex-wrap items-center gap-2 mt-4">
            <x-utils.button label="Default"></x-utils.button>
            <x-utils.button label="Theme" color="theme"></x-utils.button>
            <x-utils.button label="Theme 2" color="theme-2"></x-utils.button>
            <x-utils.button label="Light" color="light"></x-utils.button>
            <x-utils.button label="Dark" color="black"></x-utils.button>
            <x-utils.button label="Button sm" size="sm"></x-utils.button>
            <x-utils.button label="Button xs" size="xs"></x-utils.button>
        </div>
        <div class="flex flex-wrap items-center gap-2 mt-2">
            <x-utils.button label="Default (icon)" icon="icon-search"></x-utils.button>
            <x-utils.button label="Default (r-icon)" color="light" r-icon="icon-chevron-right"></x-utils.button>
            <x-utils.button label="Default (r-icon)" color="black" icon="icon-envelope" r-icon="icon-chevron-right" size="xs"></x-utils.button>
            <x-utils.button label="Label filtred" color="black" r-icon="icon-times" size="xs"></x-utils.button>
        </div>

        <div class="mt-8"><b>Label</b></div>
        <div class="flex flex-wrap items-center gap-2 mt-4">
            <x-utils.label label="Small label"></x-utils.button>
            <x-utils.label label="Small label gray" color="gray"></x-utils.button>
        </div>

        <div class="mt-8"><b>Box</b></div>
        <div class="mt-4 select-none" x-data="{ change(target){
                $el.querySelectorAll('[name=inp_radio]').forEach( (el) => {
                    const data = Alpine.$data(el).active = (el==target);
                });
            },
            select(target){
                const radio = target.querySelector('[type=radio]');
                if(radio!=null){
                    radio.click();
                }
            }}">
            <x-utils.box x-data="{active : false}" @click="select($event.target)">
                <x-forms.elements.radio class="inline-block" name="inp_radio" value="1" @change="change($event.target)" /> Box default
            </x-utils.box>
            <x-utils.box class="mt-2" x-data="{active : true}" @click="select($event.target)">
                <x-forms.elements.radio class="inline-block" name="inp_radio" value="2" @change="change($event.target)" checked/> Box active
            </x-utils.box>
        </div>

        <x-utils.box class="mt-2" color="gray">
            Box gray
        </x-utils.box>

    </x-utils.container>

</x-layouts.app>
