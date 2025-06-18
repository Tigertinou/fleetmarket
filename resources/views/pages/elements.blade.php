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

        <x-forms.elements.select class="mt-4">
            <option value="0">Select option</option>
            <option value="1">Option 1</option>
            <option value="2">Option 2</option>
            <option value="3">Option 3</option>
            <option value="4">Option 4</option>
        </x-forms.elements.select>

        <input type="checkbox">

    </div>

</x-layouts.app>
