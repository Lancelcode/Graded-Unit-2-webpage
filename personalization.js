
document.addEventListener('DOMContentLoaded', () => {
    const recommendationsGrid = document.getElementById('recommendations-grid');
    const trendingGrid = document.getElementById('trending-grid');

    // Mock data for recommendations
    const recommendations = [
        { title: "Action Movie 1", img: "img/1.jpg" },
        { title: "Comedy Movie 2", img: "img/2.jpg" },
        { title: "Drama Movie 3", img: "img/3.jpg" },
        { title: "Blockbuster 1", img: "img/4.jpg" },
    ];

    // Mock data for trending
    const trending = [
        { title: "Blockbuster 1", img: "img/4.jpg" },
        { title: "Award Winner 2", img: "img/5.jpg" },
        { title: "Fan Favorite 3", img: "img/6.jpg" },
        
    ];

    // Populate recommendations
    recommendations.forEach(movie => {
        const card = document.createElement('div');
        card.classList.add('movie-card');
        card.innerHTML = `
            <img src="${movie.img}" alt="${movie.title}">
            <h3>${movie.title}</h3>
        `;
        recommendationsGrid.appendChild(card);
    });

    // Populate trending
    trending.forEach(movie => {
        const card = document.createElement('div');
        card.classList.add('movie-card');
        card.innerHTML = `
            <img src="${movie.img}" alt="${movie.title}">
            <h3>${movie.title}</h3>
        `;
        trendingGrid.appendChild(card);
    });
});
