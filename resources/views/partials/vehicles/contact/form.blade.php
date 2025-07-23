
<form x-data="{
        showMessage: false
    }" class="flex flex-col h-full" method="POST" action="" id="contact-form">
    <div>
        <p class="mb-4 text-sm">Remplissez le formulaire ci-dessous pour nous contacter et recevoir votre devis.</p>
    </div>
    <div class="flex-1">
        <div class="flex flex-col gap-2 mb-4">
            <div class="flex-1">
                <input type="text" name="inp_firstname" class="w-full px-4 py-4 text-sm font-normal border-gray-300 h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="Prénom *" required>
            </div>
            <div class="flex-1">
                <input type="text" name="inp_lastname" class="w-full px-4 py-4 text-sm font-normal border-gray-300 h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="Nom de famille *" required>
            </div>
            <div class="flex-1">
                <input type="email" name="inp_email" class="w-full px-4 py-4 text-sm font-normal border-gray-300 h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="Email *" required>
            </div>
            <div class="flex-1">
                <input type="tel" name="inp_phone" class="w-full px-4 py-4 text-sm font-normal border-gray-300 h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="Téléphone *" required>
            </div>
            <div class="flex-1">
                <input type="text" name="inp_postcode" class="w-full px-4 py-4 text-sm font-normal border-gray-300 h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="Code postal*" required>
            </div>
            <div class="flex-1">
                <x-forms.elements.switch class="mb-2 text-sm" name="inp_display_message" label="Ajouter nu message" value="1" x-init="$watch(`toggled`, value => showMessage = value)"
                x-effect="toggled = showMessage"/>
                <textarea name="inp_message" class="w-full h-24 px-4 py-3 text-sm font-normal border-gray-300 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="Message" x-show="showMessage"></textarea>
            </div>
        </div>
    {{--
        email : <input type="email" name="email" required>
        téléphone : <input type="tel" name="phone" required>
        message : <textarea name="message" required></textarea>
        <button type="submit">Envoyer</button>
        <input type="hidden" name="versionId" value="{{ $versionId ?? '' }}">
        <input type="hidden" name="vehicleId" value="{{ $vehicleId ?? '' }}">
        <input type="hidden" name="makeId" value="{{ $makeId ?? '' }}">
        <input type="hidden" name="modelId" value="{{ $modelId ?? '' }}">
        <input type="hidden" name="versionName" value="{{ $versionName ?? '' }}">
        <input type="hidden" name="vehicleName" value="{{ $vehicleName ?? '' }}">
        <input type="hidden" name="makeName" value="{{ $makeName ?? '' }}">
        <input type="hidden" name="modelName" value="{{ $modelName ?? '' }}">
        <input type="hidden" name="options" value="{{ json_encode($options ?? []) }}">
        <input type="hidden" name="locale" value="{{ app()->getLocale() }}">
        <input type="hidden" name="csrf_token" value="{{ csrf_token() }}">
        <input type="hidden" name="redirectUrl" value="{{ $redirectUrl ?? '' }}">
        <input type="hidden" name="redirectUrlParams" value="{{ $redirectUrlParams ?? '' }}">
        <input type="hidden" name="redirectUrlQuery" value="{{ $redirectUrlQuery ?? '' }}"> --}}
    </div>
    <div>
        <x-utils.button label="Envoyer" color="theme" class="w-full max-w-sm" @click="alert('ok')"></x-utils.button>
    </div>
</form>
