<div {{ $attributes->merge(['class' => '']) }}>

    <x-forms.elements.range
        name="inp_"
        min="0"
        max="100000"
        min-value="5000"
        max-value="95000"
        step="5000"
        label="Votre budget"/>

    <x-forms.elements.select class="mt-4" multiple :options="[]" name="inp_brands" placeholder="Select your brand ..."/>

</div>
