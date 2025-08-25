@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
    ['label' => 'Comparer véhicules']
]
@endphp
<x-layouts.app :title="'Comparer véhicules'" :$breadcrumb>

    <x-utils.container>
        <h1 class="h1">Comparer véhicules</h1>
        <p><i>{{ __tl('Bientôt disponible...') }}</i></p>
        <button type="button" onclick="window.comparator.openModal()">Lancer le comparateur</button>
        <x-layouts.modal ref="comparatorModal" id="comparator-modal"></x-layouts.modal>
    </x-utils.container>

</x-layouts.app>
<script>
window.comparator = {
    async openModal() {
        const modal = document.getElementById('comparator-modal');
        if (modal) {
            const response = await fetch(`/{{ app()->getLocale() }}/partials/vehicles/comparator/modal`);
            modal.querySelector('[data-area="title"]').innerHTML = `{{ __tl('Ajoutez un véhicule') }}`;
            const html = await response.text();
            const contentEl = modal.querySelector('[data-area="content"]');
            contentEl.innerHTML = html;

            await modal.querySelectorAll('script').forEach(script => {
                const newScript = document.createElement('script');
                newScript.textContent = script.textContent;
                document.body.appendChild(newScript);
            });

            if (window.Alpine && typeof Alpine.initTree === 'function') {
                Alpine.initTree(contentEl);
            }

            modal.classList.add('loaded');
            Alpine.$data(document.querySelector('body')).comparatorModalOpen = true;
        }
    }
}
</script>
