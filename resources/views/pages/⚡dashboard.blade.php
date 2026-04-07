<?php

use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

new #[Title('Dashboard')] class extends Component {
    //
};
?>

<div class="flex flex-col space-y-4">
    <flux:heading size="xl">Dashboard</flux:heading>
    <flux:modal.trigger name="edit-profile">
        <flux:button variant="primary" class="w-fit">Agregar inversion</flux:button>
    </flux:modal.trigger>
    <flux:modal name="edit-profile" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Agregar inversion</flux:heading>
                <flux:text class="mt-2">Agrega los datos de la nueva inversión.</flux:text>
            </div>
            <flux:input label="Nombre" placeholder="Nombre de la inversión" />
            <flux:input.group label="Monto">
                <flux:input.group.prefix>$</flux:input.group.prefix>
                <flux:input mask:dynamic="$money($input)" placeholder="0.00" />
            </flux:input.group>
            <flux:input label="Fecha de inicio" type="date" />
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Agregar</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
