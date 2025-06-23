@php
$breadcrumb = [
    ['url' => localized_route('pages.home'), 'label' => '<span class="text-xs font-thin icon icon-home" />', 'class' => 'font-semibold text-black'],
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

        <div class="flex flex-wrap items-center gap-2 mt-4">
            <x-forms.elements.checkbox class="inline-block" name="inp_checkbox_simple" label="Large (lg) checkbox (checked)" size="lg"/>
            <x-forms.elements.checkbox class="inline-block" name="inp_checkbox_checked" label="Default (md) checkbox (checked)" checked/>
            <x-forms.elements.checkbox class="inline-block" name="inp_checkbox_checked" label="Small (sm) checkbox (checked)" size="sm" checked/>
        </div>

        <div class="flex flex-wrap items-center gap-2 mt-4">
            <x-forms.elements.checkbox class="inline-block" name="inp_checkbox_small" label="Checkbox (no checked)" />
            <x-forms.elements.checkbox class="inline-block" name="inp_checkbox_checked" label="Checkbox (Checked)" checked/>
            <x-forms.elements.checkbox class="inline-block" name="inp_checkbox_disabled" label="Checkbox (Disabled)" disabled/>
        </div>


        <div class="mt-8"><b>Radio</b></div>

        <div class="flex flex-wrap items-center gap-2 mt-4">
            <x-forms.elements.radio class="inline-block" name="inp_radio_simple" label="Large (lg) radio (checked)" value="1" size="lg"/>
            <x-forms.elements.radio class="inline-block" name="inp_radio_simple" label="Default (md) radio (checked)" value="2" checked/>
            <x-forms.elements.radio class="inline-block" name="inp_radio_simple" label="Small (sm) radio (checked)" value="3" size="sm"/>
        </div>

        <div class="flex flex-wrap items-center gap-2 mt-4">
            <x-forms.elements.radio class="inline-block" name="inp_radio_md" label="Radio (no checked)" value="1" />
            <x-forms.elements.radio class="inline-block" name="inp_radio_md" label="Radio (Checked)" value="2" checked/>
            <x-forms.elements.radio class="inline-block" name="inp_radio_md" label="Radio (Disabled)" value="3" disabled/>
        </div>

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
            <x-utils.button label="Button lg" size="lg"></x-utils.button>
            <x-utils.button label="Button md (default)" size="md"></x-utils.button>
            <x-utils.button label="Button sm" size="sm"></x-utils.button>
            <x-utils.button label="Button xs" size="xs"></x-utils.button>
        </div>
        <div class="flex flex-wrap items-center gap-2 mt-2">
            <x-utils.button label="Theme" color="theme"></x-utils.button>
            <x-utils.button label="Theme 2" color="theme-2"></x-utils.button>
            <x-utils.button label="Light" color="light"></x-utils.button>
            <x-utils.button label="Bordered" color="bordered"></x-utils.button>
            <x-utils.button label="Dark" color="black"></x-utils.button>
        </div>
        <div class="flex flex-wrap items-center gap-2 mt-2">
            <x-utils.button label="Button icon lg" size="lg" icon="icon-search" r-icon="icon-chevron-right"></x-utils.button>
            <x-utils.button label="Button icon md" size="md" icon="icon-search" r-icon="icon-chevron-right"></x-utils.button>
            <x-utils.button label="Button icon sm" size="sm" icon="icon-search" r-icon="icon-chevron-right"></x-utils.button>
            <x-utils.button label="Button icon xs" size="xs" icon="icon-search" r-icon="icon-chevron-right"></x-utils.button>
        </div>
        <div class="flex flex-wrap items-center gap-2 mt-2">
            <x-utils.button label="Default (icon)" icon="icon-search"></x-utils.button>
            <x-utils.button label="Default (r-icon)" color="light" r-icon="icon-chevron-right"></x-utils.button>
            <x-utils.button label="Default (r-icon)" color="black" icon="icon-envelope" r-icon="icon-chevron-right" size="xs"></x-utils.button>
            <x-utils.button label="Label filtred" color="black" r-icon="icon-times" size="xs"></x-utils.button>
        </div>
        <div class="flex flex-wrap items-center gap-2 mt-2">
            <x-utils.button label="Button align none" icon="icon-search" r-icon="icon-chevron-right" class="w-full max-w-sm"></x-utils.button>
            <x-utils.button label="Button align center" icon="icon-search" r-icon="icon-chevron-right" class="w-full max-w-sm" align="center"></x-utils.button>
            <x-utils.button label="Button align right" icon="icon-search" r-icon="icon-chevron-right" class="w-full max-w-sm" align="right"></x-utils.button>
            <x-utils.button label="Button align left" icon="icon-search" r-icon="icon-chevron-right" class="w-full max-w-sm" align="left"></x-utils.button>

        </div>

        <div class="mt-8"><b>Modals</b></div>
        <div class="mb-2" x-data="{ customModalOpen : false }">
            <x-utils.button label="Open little modal" x-on:click="customModalOpen=true"></x-utils.button>
            <x-layouts.modal title="Modal title" ref="customModal">
                Contenu de ma modal
            </x-layouts.modal>
        </div>

        <div x-data="{ customModalOpen : false }">
            <x-utils.button label="Open large modal" x-on:click="customModalOpen=true"></x-utils.button>
            <x-layouts.modal title="Modal title" ref="customModal">
                <p>Lorem ipsum dolor sit amet. Est nulla reiciendis sed saepe aperiam et quia neque est voluptas quis qui harum vitae nam similique voluptas. Et enim quasi non porro excepturi sit iure accusantium. Ut voluptas quos At beatae accusantium sed consequatur nisi sed dolorum ipsam ea cumque deserunt! </p><p>Ut inventore iste sit earum tempore ex velit possimus sed labore illum vel animi repellat et quia aperiam qui earum quaerat. Id sunt natus hic maxime molestiae 33 quasi quos et nihil veniam ut eveniet quia eum aspernatur ratione. </p><p>Qui tenetur perspiciatis sit error impedit quo adipisci rerum 33 provident consequatur aut Quis mollitia. Nam debitis eius qui nihil recusandae sed neque sint sit natus minima et accusantium enim aut culpa sequi. Aut eaque ullam non distinctio tempore est temporibus aperiam? </p><p>Non autem odio nam fuga dolores eos consequuntur consequuntur non assumenda quia cum perferendis enim et rerum similique aut voluptatem Quis. Ab repellat galisum est atque voluptatem id reprehenderit nihil At sunt maiores eos eveniet similique aut quidem ratione. </p><p>Et recusandae internos id exercitationem voluptatem non quia quas est quisquam voluptas qui alias minus ea ullam accusamus. Rem corrupti illum et nostrum fugit qui quis consequuntur et perspiciatis consequatur qui dolor esse 33 velit voluptas. </p><p>Ut tempora unde et quasi facilis aut optio laboriosam et sunt dolores. Eum laboriosam placeat aut cupiditate dolores eos quas libero id rerum adipisci At laudantium consequatur et omnis provident. </p><p>Cum labore quasi eos esse nisi sed tenetur sapiente 33 consequatur doloribus sed optio officia qui ducimus sequi. Ea consectetur recusandae vel deleniti cumque ea rerum eligendi sed pariatur voluptatem. Ut voluptatibus odit eos libero quia aut corrupti quasi et galisum sint sed quaerat fugiat. Et eveniet cupiditate et ducimus sapiente sit molestiae eaque ut consequatur recusandae et atque accusamus. </p><p>Aut animi omnis et nemo voluptas et enim aliquid aut eligendi velit non dignissimos veniam ea internos modi! Est delectus similique est explicabo vero ut accusantium distinctio non repellendus corporis sit provident ducimus in rerum odit. Est recusandae facilis ut voluptatum autem At quaerat dolorem et ipsum quidem quo obcaecati magnam sed excepturi reprehenderit aut unde labore. Eum dolorem internos ea reiciendis quod sit nemo distinctio ut repellat unde est possimus fugiat qui aspernatur saepe quo illo quod! </p><p>Id illum dolorem aut ducimus veritatis qui eius distinctio sit dolore obcaecati? Ut nisi excepturi est eius veniam est exercitationem rerum et consequuntur voluptatem. Eum beatae blanditiis qui perferendis rerum ad repellendus reiciendis qui amet quae eos mollitia quam est incidunt aliquid. A quaerat minima et magnam cupiditate non alias expedita hic odio voluptas ut dolor culpa. </p><p>Et blanditiis modi vel laborum ratione eum quos sunt cum voluptatem deleniti vel odio molestias ex sapiente rerum. Qui possimus obcaecati quo expedita natus est enim atque in quae velit est nihil animi. Sed laboriosam incidunt et nulla expedita et aperiam autem ut officiis reprehenderit sed reprehenderit tempora non veritatis fuga eum mollitia galisum. </p><p>Ex accusantium omnis eum quidem aliquam et reprehenderit voluptatem eum pariatur laudantium nam voluptas similique. Eos rerum quidem ut aliquam officia et necessitatibus vero sit alias laborum eos temporibus velit. </p><p>Est numquam dolores 33 quos quis et quod pariatur sit voluptatem eligendi. Qui atque repellendus aut incidunt distinctio ut similique esse et quidem unde? Ea illum delectus rem cumque minima ex galisum debitis et optio sequi. Eos molestias dolorem ut tempore cumque sit assumenda eius ab excepturi autem et omnis facilis hic nemo dolore aut mollitia totam. </p><p>Sit ipsum dolor ut eaque culpa quo excepturi molestiae. Ea minima sunt qui temporibus voluptas in impedit repellat. 33 molestiae ratione ut autem inventore ut ullam nostrum a voluptatibus repellendus est maiores excepturi aut voluptas esse. Est delectus molestiae sed fuga expedita non dolorem numquam ut saepe repellendus. </p><p>Nam internos suscipit et aspernatur labore 33 fugiat nemo qui quidem temporibus et Quis voluptatum et similique quaerat! Qui rerum quibusdam et totam aperiam a eius omnis et dolore harum At libero laborum in modi blanditiis non alias sint. Est mollitia dolor et facilis fugit sit illo atque ut dolores quas aut dolores molestiae aut suscipit reiciendis aut quam quia. Est accusantium explicabo quo accusamus voluptatem sit aliquid tenetur sed iste omnis est voluptas dolorem qui saepe molestiae quo veritatis repellat. </p><p>Ut delectus maiores qui omnis laborum eum aliquid dolores est ipsum ducimus. Ut magni voluptas ut distinctio veniam eum aspernatur provident. Ut quia dicta non dolorem commodi quo iste labore sit velit necessitatibus et dolores quisquam. In eaque officiis 33 dolorum dicta ea dolorum aspernatur nam eveniet omnis vel doloribus enim et error consectetur ad dolore itaque. </p><p>Et delectus asperiores est dolorem pariatur est itaque minus est commodi galisum! Sit nisi provident eum autem dignissimos id dicta amet vel velit doloremque et consequatur molestias? </p>

            </x-layouts.modal>
        </div>

        <div class="mt-8"><b>Label</b></div>
        <div class="flex flex-wrap items-center gap-2 mt-4">
            <x-utils.label label="Small label" />
            <x-utils.label label="Small label gray" color="gray" />
            <x-utils.label label="Small label r-icon" r-icon="icon-times" />
        </div>

        <div class="mt-8"><b>Box</b></div>
        <div class="mt-4 select-none" x-data="{ 
            change(target){
                $el.querySelectorAll('[name=inp_radio]').forEach( (el) => {
                    const data = Alpine.$data(el).active = (el==target);
                });
            },
            select(target){
                const radio = target.closest('.box').querySelector('[type=radio]');
                if(radio!=null){
                    radio.click();
                }
            }}">
            <x-utils.box x-data="{active : false}">
                <div class="flex gap-3" @click="select($event.target)">
                    <x-forms.elements.radio name="inp_radio" value="1" @change="change($event.target)" size="md" class="pt-0.5 -ml-2"/> 
                    <div class="flex-1"><b>Box default</b><br><small>Cum ducimus dolorem in velit Quis sed nisi voluptas 33 galisum dolor sed dolore repellat ut perspiciatis temporibus qui expedita excepturi. Et consequatur iusto ea sunt quas hic tenetur quidem a explicabo esse ut illum illo et repellendus vero aut porro nisi.</small></div>
                </div>
            </x-utils.box>
            <x-utils.box class="mt-2" x-data="{active : true}">
                <div class="flex gap-3" @click="select($event.target)">
                    <x-forms.elements.radio name="inp_radio" value="2" @change="change($event.target)" size="md" class="pt-0.5 -ml-2" checked/> 
                    <div class="flex-1"><b>Box active</b><br><small>Cum ducimus dolorem in velit Quis sed nisi voluptas 33 galisum dolor sed dolore repellat ut perspiciatis temporibus qui expedita excepturi. Et consequatur iusto ea sunt quas hic tenetur quidem a explicabo esse ut illum illo et repellendus vero aut porro nisi.</small></div>
                </div>
            </x-utils.box>
        </div>

        <x-utils.box class="mt-2" color="gray">
            Box gray
        </x-utils.box>

    </x-utils.container>

</x-layouts.app>
