@extends('email.template')

@section('title')
Votre paiement a été enregistré
@endsection

@section('mailTitle')
Votre paiement a été enregistré
@endsection

@section('content')
	<p>Bonjour {{ $payment->client->surname }},</p>
	<p>Votre commande <b>{{ $payment->command_number }}</b> a bien été enregistrée. Vous bénéficiez dès maintenant des avantages suivants :</p>

	<ul>
		@if($payment->plan->reserve) 
			<li>Réserver des salles et du matériel</li>
		@endif
		@if($payment->plan->order_meal) 
			<li>Commander des plateaux repas</li>
		@endif
		@foreach($payment->plan->advantages as $advantage)
			<li>{{ $advantage->description }}</li>
		@endforeach
	</ul>

	<h4>Détails du paiement</h4>
	
	<table cellspacing="8px" cellpadding="8px" style="text-align: left; border-top: 1px solid #ddd;" width="100%">
        <tbody>
          <tr>
            <th>Numéro de commande</th>
            <th>Forfait</th>
            <th>Date du paiement</th>
            <th>Date d'expiration</th>
            <th>Prix</th>
          </tr>
          <?php 
            $formatCreated = new DateTime($payment->created_at);
            $formatLimit = new DateTime($payment->limit_date);
          ?>
          <tr>
            <td>{{ $payment->command_number }}</td>
            <td>{{ $payment->plan->name }}</td>
            <td>{{ $formatCreated->format('d/m/Y') }}</td>
            <td>{{ $formatLimit->format('d/m/Y') }}</td>
            <td>{{ $payment->plan->price }}€</td>
          </tr>
        </tbody>
      </table>
@endsection