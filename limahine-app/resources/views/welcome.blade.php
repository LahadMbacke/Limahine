<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Accueil – Limahine </title>
  <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">

  <!-- Navbar -->
  <nav class="bg-white shadow">
    <div class="container mx-auto px-6 py-4 flex justify-between items-center">
      <a href="{{ url('/') }}" class="text-2xl font-bold text-gray-800">Limahine </a>
      <div class="flex space-x-4">
        <a href="{{ url('/biography') }}" class="text-gray-600 hover:text-gray-800">Biographie</a>
        <a href="{{ url('/writing') }}" class="text-gray-600 hover:text-gray-800">Écrits</a>
        <a href="{{ url('/philosophy') }}" class="text-gray-600 hover:text-gray-800">Philosophie</a>
        <a href="{{ url('/testimonials') }}" class="text-gray-600 hover:text-gray-800">Témoignages</a>
        <a href="{{ url('/resources') }}" class="text-gray-600 hover:text-gray-800">Chercheurs</a>
              <a href="{{ url('/publish') }}" class="text-gray-600 hover:text-gray-800">Publier</a>

      </div>
    </div>
  </nav>

  <!-- Hero Section -->
  <section class="bg-white py-20">
    <div class="container mx-auto px-6 text-center">
      <h1 class="text-5xl font-bold mb-4">Bienvenue sur Limahine </h1>
      <p class="text-xl text-gray-700 mb-8">
        Explorer, comprendre et partager l’héritage spirituel et intellectuel de Cheikh Ahmadou Bamba et du Mouridisme.
      </p>
      <a href="#mission" class="bg-green-600 text-white px-6 py-3 rounded-full hover:bg-green-700 transition">Notre Mission</a>
    </div>
  </section>

  <!-- Mission & Vision -->
  <section id="mission" class="container mx-auto px-6 py-16">
    <div class="grid md:grid-cols-2 gap-12 items-center">
      <div>
        <h2 class="text-3xl font-bold mb-4">Notre Mission</h2>
        <p class="text-gray-700 mb-6">
          Vulgariser et diffuser les khassaïdes, écrits et enseignements de Cheikh Ahmadou Bamba à un public mondial, en offrant des contenus fiables, validés par un comité scientifique.
        </p>
        <h2 class="text-3xl font-bold mb-4">Notre Vision</h2>
        <p class="text-gray-700">
          Devenir la référence digitale pour toute personne, chercheur ou passionné, souhaitant approfondir sa connaissance du mouridisme et de la lignée de Cheikh Ahmadou Bamba.  
        </p>
      </div>
    </div>
  </section>

  <!-- Objectifs clés -->
  <section class="bg-white py-16">
    <div class="container mx-auto px-6">
      <h2 class="text-3xl font-bold mb-8 text-center">Objectifs Clés</h2>
      <div class="grid md:grid-cols-3 gap-8">
        <div class="bg-gray-50 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2">Biographie détaillée</h3>
          <p class="text-gray-600">
            Retracer le parcours de Cheikh Ahmadou Bamba à travers une chronologie illustrée et des récits inédits.
          </p>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2">Écrits et khassaïdes</h3>
          <p class="text-gray-600">
            Mettre à disposition des textes originaux, des traductions (FR/EN/WO) et des enregistrements audio.
          </p>
        </div>
        <div class="bg-gray-50 p-6 rounded-lg shadow hover:shadow-lg transition">
          <h3 class="text-xl font-semibold mb-2">Ressources pour chercheurs</h3>
          <p class="text-gray-600">
            Offrir une bibliothèque académique numérique avec sources primaires, articles et outils de recherche.
          </p>
        </div>
      </div>
    </div>
  </section>

  <!-- Aperçu des sections -->
  <section class="container mx-auto px-6 py-16">
    <h2 class="text-3xl font-bold mb-8 text-center">Au sommaire</h2>
    <div class="grid md:grid-cols-4 gap-6">
      <!-- Biographie -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
        <img src="icon-biography.svg" alt="" class="mx-auto mb-4 w-16">
        <h3 class="text-xl font-semibold mb-2">Biographie</h3>
        <p class="text-gray-600 mb-4">Histoire et vie de Cheikh Ahmadou Bamba.</p>
        <a href="{{ url('/biography') }}" class="text-green-600 hover:underline">Voir la section →</a>
      </div>
      <!-- Écrits -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
        <img src="icon-writing.svg" alt="" class="mx-auto mb-4 w-16">
        <h3 class="text-xl font-semibold mb-2">Écrits</h3>
        <p class="text-gray-600 mb-4">Khassaïdes, poèmes et prose spirituelle.</p>
        <a href="{{ url('/writing') }}" class="text-green-600 hover:underline">Voir la section →</a>
      </div>
      <!-- Philosophie -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
        <img src="icon-philosophy.svg" alt="" class="mx-auto mb-4 w-16">
        <h3 class="text-xl font-semibold mb-2">Philosophie</h3>
        <p class="text-gray-600 mb-4">Principes et enseignements mourides.</p>
        <a href="{{ url('/philosophy') }}" class="text-green-600 hover:underline">Voir la section →</a>
      </div>
      <!-- Témoignages -->
      <div class="bg-white p-6 rounded-lg shadow hover:shadow-lg transition text-center">
        <img src="icon-testimonials.svg" alt="" class="mx-auto mb-4 w-16">
        <h3 class="text-xl font-semibold mb-2">Témoignages</h3>
        <p class="text-gray-600 mb-4">Récits de disciples et descendants.</p>
        <a href="{{ url('/testimonials') }}" class="text-green-600 hover:underline">Voir la section →</a>
      </div>
    </div>
  </section>

  <section id="posts" class="bg-yellow-50 py-16">
    <div class="container mx-auto px-6">
        <h2 class="text-3xl font-bold mb-8 text-center text-yellow-700">Articles Récents</h2>
        <div class="grid md:grid-cols-3 gap-8">
            @foreach($posts as $post)
                @if($post->is_published)
                    <div class="bg-yellow-100 p-6 rounded-lg shadow hover:shadow-lg transition">
                        <h3 class="text-xl font-semibold mb-2 text-yellow-800">{{ $post->title }}</h3>
                        <p class="text-yellow-700 mb-4">{{ Str::limit($post->content, 100) }}</p>
                        <a href="#" class="text-yellow-600 hover:underline">Lire plus →</a>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</section>

<!-- Call to Action YouTube -->
<section class="bg-yellow-800 shadow mt-12">
    <div class="container mx-auto px-6 text-center text-white">
        <h2 class="text-3xl font-bold mb-4">Notre chaîne YouTube</h2>
        <p class="mb-6">Plongez dans nos vidéos de récitation, d’exégèse et de témoignages sur Limahine.</p>
        <a href="https://www.youtube.com/@limaahinetv2949" target="_blank" class="bg-white text-yellow-600 px-6 py-3 rounded-full hover:bg-yellow-700 transition">
            S’abonner maintenant
        </a>
    </div>
</section>

<!-- Footer -->
<footer class="bg-yellow-800 shadow mt-12">
    <div class="container mx-auto px-6 py-4 text-center text-yellow-100">
        &copy; 2025 Limahine. Tous droits réservés.
    </div>
</footer>