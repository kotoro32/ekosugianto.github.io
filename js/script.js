document.addEventListener('DOMContentLoaded', function() {
    // Fetch klub data from server
    fetch('get_clubs.php')
        .then(response => response.json())
        .then(data => {
            const homeTeamSelect = document.getElementById('homeTeam');
            const awayTeamSelect = document.getElementById('awayTeam');
            
            data.forEach(club => {
                const option = document.createElement('option');
                option.value = club.id;
                option.textContent = club.name;
                homeTeamSelect.appendChild(option.cloneNode(true));
                awayTeamSelect.appendChild(option);
            });
        })
        .catch(error => console.error('Error:', error));
    
    // Handle form submission to add new club
    document.getElementById('clubForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(this);

        fetch('add_club.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    });

    // Handle form submission to add match score
    document.getElementById('matchForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        const formData = new FormData(this);

        fetch('add_score.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.text())
        .then(data => {
            alert(data);
            location.reload();
        })
        .catch(error => console.error('Error:', error));
    });

    // Fetch and display standings
    fetch('get_standings.php')
        .then(response => response.text())
        .then(data => {
            document.getElementById('standings').innerHTML = data;
        })
        .catch(error => console.error('Error:', error));
});