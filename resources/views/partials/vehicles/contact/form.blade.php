
<form x-data="{
        showMessage: false,
        init() {
            console.log('Contact form initialized');
            const form = document.querySelector('#contact-form');
            form.querySelector('input[name=inp_firstname]').value = 'Quentin';
            form.querySelector('input[name=inp_lastname]').value = 'Ballinger';
            form.querySelector('input[name=inp_email]').value = 'q.b@mouseonmove.com';
            form.querySelector('input[name=inp_phone]').value = '+32477821572';
            form.querySelector('input[name=inp_postcode]').value = '1020';
        },
        submitForm() {
            const form = document.querySelector('#contact-form');
            if (form.checkValidity()) {
                const data = {
                    make: makeSelected,
                    model: modelSelected,
                    finition: finitionSelected,
                    motor: motorSelected,
                    version: version?.versionName ?? '',
                    colorExternal: colorExternalSelected?.description ?? '',
                    colorInterior: colorInteriorSelected?.description ?? '',
                    equipments: equipmentsSelected.map(e => e.idEquipment),
                    total: total.total,
                    firstname: form.inp_firstname.value,
                    lastname: form.inp_lastname.value,
                    email: form.inp_email.value,
                    phone: form.inp_phone.value,
                    postcode: form.inp_postcode.value,
                    message: form.inp_message.value,
                };
                alert('Form data: ' + JSON.stringify(data, null, 2));
                {{-- form.submit(); --}}
            } else {
                form.reportValidity();
            }
        }
    }" class="flex flex-col h-full" method="POST" id="contact-form">
    <input type="hidden" name="inp_data" value="">
    <div>
        <p class="mb-4 text-sm">{{ __tl('Remplissez le formulaire ci-dessous pour nous contacter et recevoir votre devis.') }}</p>
    </div>
    <div class="flex-1 mb-4">
        <div class="flex flex-col gap-2 mb-4">
            <div class="flex-1">
                <input type="text" name="inp_firstname" class="w-full px-4 py-4 text-sm font-normal border-gray-300 rounded-sm h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="{{ __tl('Prénom') }} *" required>
            </div>
            <div class="flex-1">
                <input type="text" name="inp_lastname" class="w-full px-4 py-4 text-sm font-normal border-gray-300 rounded-sm h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="{{ __tl('Nom de famille') }} *" required>
            </div>
            <div class="flex-1">
                <input type="email" name="inp_email" class="w-full px-4 py-4 text-sm font-normal border-gray-300 rounded-sm h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="{{ __tl('Email') }} *" required>
            </div>
            <div class="flex-1">
                <input type="tel" name="inp_phone" class="w-full px-4 py-4 text-sm font-normal border-gray-300 rounded-sm h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="{{ __tl('Téléphone') }} *" required>
            </div>
            <div class="flex-1">
                <input type="text" name="inp_postcode" class="w-full px-4 py-4 text-sm font-normal border-gray-300 rounded-sm h-11 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="{{ __tl('Code postal') }} *" required>
            </div>
            <div class="flex-1">
                <x-forms.elements.select class="rounded-sm text-theme" :options="
                array(
                    array( 'value' => '', 'name' => 'Aucune préférence' ),
                    array( 'value' => 'fr', 'name' => 'Je souhaite communiquer en <b>français</b>' ),
                    array( 'value' => 'nl', 'name' => 'Je souhaite communiquer en <b>néerlandais</b>' ),
                    array( 'value' => 'en', 'name' => 'Je souhaite communiquer en <b>anglais</b>' ),
                )" :values="app()->getLocale()" name="inp_lang" placeholder="Langue"/>
            </div>
            <div>
                <div class="mt-4 text-2xl">{{ __tl('Objet de ma demande') }}</div>
                <div>
                    <p class="mt-2 mb-4 text-sm">{{ __tl('Les informations suivantes seront transmises.') }}</p>
                </div>
                <x-utils.box color="gray" class="w-full my-4 text-sm">
                    <div class="pb-4 mt-2 mb-4 border-b border-gray-400">
                        <span class="text-lg font-bold leading-4" x-text="makeSelected"></span> <span class="text-lg font-normal leading-4" x-text="modelSelected"></span><br>
                        <span class="text-sm font-semibold" x-text="finitionSelected"></span><br>
                        <span class="text-sm font-normal" x-text="version?.versionName ?? ''"></span>
                    </div>
                    <div class="flex">
                        <div class="flex-1">{{ __tl('Prix de base') }}</div>
                        <div class="self-end" x-text="total.base.toEuro()">-</div>
                    </div>
                    <div class="flex flex-col gap-2 py-2 my-2 text-xs border-gray-400 border-dashed border-y" >
                        <template x-if="colorExternalSelected !== null">
                            <div class="flex">
                                <div class="flex-1" x-text="'+ ' + ( colorExternalSelected.description!=null ? colorExternalSelected.description : '')"></div>
                                <div class="self-end" x-text="'+ ' + (colorExternalSelected.msrpPrice || 0).toEuro()">-</div>
                            </div>
                        </template>
                        <template x-if="colorInteriorSelected !== null">
                            <div class="flex">
                                <div class="flex-1" x-text="'+ ' + ( colorInteriorSelected.description!=null ? colorInteriorSelected.description : '')"></div>
                                <div class="self-end" x-text="'+ ' + (colorInteriorSelected.msrpPrice || 0).toEuro()">-</div>
                            </div>
                        </template>
                        <template x-for="equipment in equipmentsSelected" >
                            <div class="flex">
                                <div class="flex-1" x-text="'+ ' + equipment.description"></div>
                                <div class="self-end" x-text="'+ ' + ( equipment.msrp || 0).toEuro()">-</div>
                            </div>
                        </template>
                    </div>
                    <div class="flex">
                        <div class="flex-1">{{ __tl('Total des options configurées') }}</div>
                        <div class="self-end" x-text="total.options.toEuro()">-</div>
                    </div>
                    <div class="flex" x-show="total.shipping">
                        <div class="flex-1">{{ __tl('Frais de livraison incluant la contribution environnementale pour le recyclage
                            de la voiture') }}</div>
                        <div class="self-end" x-text="total.shipping.toEuro()">-</div>
                    </div>
                    <div class="flex items-center mt-2">
                        <div class="flex-1 font-bold">{{ __tl('Prix total') }}</div>
                        <div class="self-end text-lg font-bold" x-html="total.total.toEuro()">-</div>
                    </div>
                    <div><small>{{ __tl('* Tous les prix affichés sont TTC') }}</small></div>
                </x-utils.box>
            </div>
            <div class="flex-1">
                <x-forms.elements.switch class="mb-2 text-sm" name="inp_display_message" label="Ajouter un message" value="1" x-init="$watch(`toggled`, value => showMessage = value)"
                x-effect="toggled = showMessage"/>
                <textarea name="inp_message" class="w-full h-24 px-4 py-3 text-sm font-normal border-gray-300 border-1 focus:outline-none text-theme placeholder:text-gray-500" placeholder="Message" x-show="showMessage"></textarea>
            </div>
            <div class="flex-1 text-xs">
                {{ __tl('En validant le formulaire, j\'accepte la') }} <a href="{{ localized_route('pages.legals') }}" class="underline" target="_blank">{{ __tl('Politique de confidentialité') }}</a> {{ __tl('et d\'être contacté(e) pour recevoir la prestation du service sollicité.') }}
            </div>
            <div class="flex-1">
                <x-forms.elements.checkbox class="inline-block text-xs" name="inp_" size="sm" position="start" required>
                    <span class="leading-2">{{ __tl('J\'accepte d\'être contacté à des fins de marketing conformément à la') }} <a href="{{ localized_route('pages.legals') }}" class="underline" target="_blank">{{ __tl('Politique de confidentialité') }}</a> {{ __tl('de FleetMarket') }}</span>
                </x-forms.elements.checkbox>
            </div>
        </div>
    </div>
    <div class="sticky bottom-0 bg-white">
        <x-utils.button label="{{ __tl('Demander mon devis') }}" color="theme" class="w-full font-semibold" @click="submitForm()"></x-utils.button>
    </div>
    <div class="mt-2 bg-white">
        <x-utils.button label="{{ __tl('Retour') }}" color="light" class="w-full" @click="contactModalOpen=false"></x-utils.button>
    </div>
</form>
