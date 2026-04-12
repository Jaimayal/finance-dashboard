<?php

use App\Models\Institution;
use App\Models\Rate;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Title;
use Livewire\Attributes\Validate;
use Livewire\Component;

new #[Title('Dashboard')] class extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|string')]
    public string $color = '#1C1F2E';

    #[Validate('required|numeric|min:0')]
    public ?int $amount = null;

    public string $displayedAmount = '';

    public function updatedDisplayedAmount($value)
    {
        $this->amount = preg_replace('/[^\d]/', '', $value);
    }

    #[Validate('required|exists:rates,id')]
    public ?int $rate_id = null;

    #[Validate('required|exists:institutions,id')]
    public ?int $institution_id = null;

    #[Validate('required|date')]
    public string $start_date = '';

    #[Validate('required|date|after:start_date')]
    public string $end_date = '';

    #[Computed]
    public function investments()
    {
        return Auth::user()->investments()->with('rate.institution')->latest()->get();
    }

    #[Computed]
    public function institutions()
    {
        return Institution::all();
    }

    #[Computed]
    public function rates()
    {
        if ($this->institution_id === null) {
            return [];
        }

        return Rate::where('institution_id', $this->institution_id)->latest()->get();
    }

    #[Computed]
    public function rate()
    {
        if ($this->rate_id === null) {
            return null;
        }

        return Rate::find($this->rate_id);
    }

    public function save()
    {
        $this->validate();

        Auth::user()->investments()->create([
            'name' => $this->name,
            'amount' => $this->amount,
            'rate_id' => $this->rate_id,
            'institution_id' => $this->institution_id,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
        ]);

        $this->reset(['name', 'amount', 'displayedAmount', 'rate_id', 'institution_id', 'start_date', 'end_date']);
    }
};
?>

<div class="max-w-5xl mx-auto py-10 px-4">
    <div class="flex items-center justify-between mb-8">
        <flux:heading size="xl">Mis inversiones</flux:heading>

        <flux:modal.trigger name="create-investment">
            <flux:button variant="primary" icon="plus">Agregar inversion</flux:button>
        </flux:modal.trigger>
    </div>

    @if ($this->investments->isEmpty())
        <div class="flex flex-col items-center justify-center">
            <flux:icon name="banknotes" class="size-10 mb-3" />
            <flux:heading size="lg">Sin inversiones aún</flux:heading>
            <flux:text class="mt-1 mb-4">Crea tu primera inversion</flux:text>
            <flux:modal.trigger name="create-investment">
                <flux:button variant="primary" icon="plus">Nueva inversion</flux:button>
            </flux:modal.trigger>
        </div>
    @else
        {{-- <flux:table>
            <flux:columns>
                <flux:column>Nombre</flux:column>
                <flux:column>Institucion</flux:column>
                <flux:column>Tasa</flux:column>
                <flux:column>Monto</flux:column>
                <flux:column>Inicio</flux:column>
                <flux:column>Fin</flux:column>
            </flux:columns>

            <flux:rows>
                @foreach ($this->investments as $investment)
                    <flux:table:row wire:key="{{ $investment->id }}">
                        <flux:table:cell>{{ $investment->name }}</flux:cell>
                    </flux:table:row>
                @endforeach
            </flux:rows>
        </flux:table> --}}
    @endif

    <flux:modal name="create-investment" class="md:w-96">
        <div class="space-y-6">
            <div>
                <flux:heading size="lg">Agregar inversion</flux:heading>
                <flux:text class="mt-2">Agrega los datos de la nueva inversión.</flux:text>
            </div>
            <flux:input wire:model="name" label="Nombre" placeholder="Nombre de la inversión" />
            <flux:input wire:model.live="displayedAmount" label="Monto" mask:dynamic="$money($input)"
                placeholder="0.00" icon="currency-dollar" />
            <flux:text>{{ $amount }}</flux:text>
            <flux:input label="Fecha de inicio" type="date" />
            <flux:select label="Institución" wire:model.live="institution_id">
                <flux:select.option value="">Selecciona una institución</flux:select.option>
                @foreach ($this->institutions as $institution)
                    <flux:select.option value="{{ $institution->id }}">{{ $institution->name }}</flux:select.option>
                @endforeach
            </flux:select>
            @if ($this->institution_id !== null)
                <flux:select label="Tasa" wire:model.live="rate_id">
                    <flux:select.option value="">Selecciona una tasa</flux:select.option>
                    @foreach ($this->rates as $rate)
                        <flux:select.option value="{{ $rate->id }}">{{ $rate->name }} - {{ $rate->annual_rate }}%
                        </flux:select.option>
                    @endforeach
                </flux:select>
            @endif
            @if ($this->rate !== null)
                <div class="flex flex-col space-y-2">
                    <flux:text>
                        Tasa anual: {{ $this->rate->annual_rate }}%
                    </flux:text>
                    <flux:text>
                        Rendimiento diario estimado: $
                        {{ number_format(($this->amount * ($this->rate->annual_rate / 100)) / 365, 2) }}
                    </flux:text>
                </div>
            @endif
            <div class="flex">
                <flux:spacer />
                <flux:button type="submit" variant="primary">Agregar</flux:button>
            </div>
        </div>
    </flux:modal>
</div>
