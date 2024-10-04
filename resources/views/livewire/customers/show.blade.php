<div>
    <x-header title="{{__('Customer') . ' - ' . $customer->name }}" separator/>

    <div class="grid grid-cols-3">
        <div class="bg-base-200 rounded-md p-4 space-y-4">
            <div>
                <x-info.title>{{__("Informações Pessoais")}}</x-info.title>
                <x-info.data title="Nome"> {{ $customer->name }}</x-info.data>
                <x-info.data title="Idade"> {{ $customer->age }}</x-info.data>
                <x-info.data title="Genero"> {{ $customer->gender }}</x-info.data>
            </div>

            <div>
                <x-info.title>{{__("Informações Profissionais")}}</x-info.title>
                <x-info.data title="Empresa">{{ $customer->company }}</x-info.data>
                <x-info.data title="Cargo">{{ $customer->position }}</x-info.data>
            </div>

            <div>
                <x-info.title>{{__("Contato")}}</x-info.title>
                <x-info.data title="Email">{{ $customer->email }}</x-info.data>
                <x-info.data title="Telefone">{{ $customer->phone }}</x-info.data>
                <x-info.data title="Linkedin">{{ $customer->linkedin }}</x-info.data>
                <x-info.data title="Facebook">{{ $customer->facebook }}</x-info.data>
                <x-info.data title="Instagram">{{ $customer->instagram }}</x-info.data>
                <x-info.data title="Twitter">{{ $customer->twitter }}</x-info.data>
            </div>

            <div>
                <x-info.title>{{__("Endereço")}}</x-info.title>
                <x-info.data title="Rua">{{ $customer->address }}</x-info.data>
                <x-info.data title="Cidade">{{ $customer->city }}</x-info.data>
                <x-info.data title="Estado">{{ $customer->state }}</x-info.data>
                <x-info.data title="CEP">{{ $customer->zip }}</x-info.data>
            </div>

            <div>
                <x-info.title>{{__("Cadastro")}}</x-info.title>
                <div>{{ $customer->created_at->diffForHumans() }}</div>
                <x-info.title>{{__("Atualização")}}</x-info.title>
                <div>{{ $customer->updated_at->diffForHumans() }}</div>
            </div>
        </div>
        <div class="col-span-2">

        </div>
    </div>
</div>
