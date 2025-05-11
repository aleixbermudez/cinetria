@extends('layouts.layout')


@section('title', 'Sobre Cinetria')

@section('content')

    <div id="container">

        <div>
            @include('components.about-us')
        </div>
        <div class="pt-5">
            @include('components.team')
        </div>
        
    </div>

    <!-- GSAP CDN -->
<script src="https://unpkg.com/gsap@3/dist/gsap.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        // Animación del título y párrafo de "about-us"
        gsap.from(".about-section h2", {
            y: -50,
            opacity: 0,
            duration: 1,
            ease: "power2.out"
        });

        gsap.from(".about-section p", {
            opacity: 0,
            delay: 0.4,
            duration: 1.2,
            y: 30,
            ease: "power2.out"
        });

        // Animación de cada miembro del equipo
        gsap.from(".team-member", {
            opacity: 0,
            y: 50,
            duration: 1,
            ease: "power2.out",
            stagger: 0.3,
            delay: 0.2
        });

        // Título y párrafo final de team
        gsap.from(".team-section h2, .team-section p", {
            opacity: 0,
            y: 20,
            duration: 1,
            delay: 0.3,
            ease: "power2.out"
        });
    });
</script>

    
    
@endsection