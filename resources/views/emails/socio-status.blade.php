<x-mail::message>
@if ($novoStatus === 'confirmado')
# Cadastro confirmado!

Olá, {{ $socio->nome }}!

Seu cadastro de sócio-torcedor do Fluminense F.C. foi **confirmado** com sucesso.

**Plano:** {{ $socio->tipo }}
**Setor:** {{ $socio->setor }}
**Data de início:** {{ $socio->data->format('d/m/Y') }}

Seja muito bem-vindo à Nação Tricolor!
@else
# Sobre o seu cadastro

Olá, {{ $socio->nome }}!

Infelizmente não foi possível confirmar seu cadastro de sócio-torcedor no momento.

Se tiver dúvidas, entre em contato com a nossa equipe.
@endif

Obrigado,<br>
{{ config('app.name') }}
</x-mail::message>