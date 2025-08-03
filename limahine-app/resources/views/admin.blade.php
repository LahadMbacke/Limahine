<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion des Contenus</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto px-6 py-12">
        <h1 class="text-4xl font-bold mb-6">Gestion des Contenus</h1>

        <!-- Formulaire pour ajouter un contenu -->
        <form action="{{ url('/admin/posts') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md mb-8">
            @csrf
            <div class="mb-4">
                <label for="title" class="block text-gray-700 font-bold mb-2">Titre</label>
                <input type="text" id="title" name="title" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="Titre de l'article ou poème" required>
            </div>
            <div class="mb-4">
                <label for="content" class="block text-gray-700 font-bold mb-2">Contenu</label>
                <textarea id="content" name="content" rows="6" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-600" placeholder="Écrivez votre contenu ici..." required></textarea>
            </div>
            <button type="submit" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">Ajouter</button>
        </form>

        <!-- Liste des contenus -->
        <h2 class="text-2xl font-bold mb-4">Contenus existants</h2>
        <div class="bg-white p-6 rounded-lg shadow-md">
            @foreach($posts as $post)
                <div class="mb-4">
                    <h3 class="text-xl font-bold">{{ $post->title }}</h3>
                    <p class="text-gray-700 mb-2">{{ $post->content }}</p>
                    <form action="{{ url('/admin/posts/'.$post->id.'/publish') }}" method="POST" class="inline-block">
                        @csrf
                        @method('PATCH')
                        @if(!$post->is_published)
                            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">Publier</button>
                        @else
                            <span class="text-green-600 font-bold">Publié</span>
                        @endif
                    </form>
                </div>
            @endforeach
        </div>
    </div>
</body>
</html>
