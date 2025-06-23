<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projects - Jacob's Portfolio</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
            color: #333;
            scroll-behavior: smooth;
        }

        .container {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            overflow: hidden;
            padding: 20px 0;
        }

        /* Header & Navigation */
        header {
            background: #222;
            color: #fff;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 2px 5px rgba(0,0,0,0.2);
            border-bottom-left-radius: 10px;
            border-bottom-right-radius: 10px;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            width: 90%;
            max-width: 1200px;
            margin: auto;
        }

        nav .logo h1 {
            margin: 0;
            color: #00bcd4;
            font-size: 1.8em;
            letter-spacing: 1px;
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        nav ul li {
            margin-left: 25px;
            position: relative;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 8px 15px;
            transition: background-color 0.3s ease, color 0.3s ease, border-radius 0.3s ease;
            border-radius: 8px;
            font-weight: 500;
        }

        nav ul li a:hover, nav ul li a.active {
            background-color: #00bcd4;
            color: #222;
            box-shadow: 0 4px 8px rgba(0, 188, 212, 0.3);
        }

        .auth-buttons {
            display: flex;
            gap: 10px;
            margin-left: 20px;
        }

        .auth-buttons .btn-auth {
            background: #00bcd4;
            color: #222;
            padding: 8px 15px;
            text-decoration: none;
            border-radius: 8px;
            transition: background-color 0.3s ease, color 0.3s ease;
        }

        .auth-buttons .btn-auth:hover {
            background: #0097a7;
            color: #fff;
        }

        /* Projects Section */
        #projects-list {
            padding: 60px 20px;
            text-align: center;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 40px;
            margin-bottom: 40px;
        }

        #projects-list h2 {
            font-size: 2.5em;
            color: #222;
            margin-bottom: 40px;
        }

        .project-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
            padding-bottom: 30px;
        }

        .project-item {
            background-color: #f9f9f9;
            border: 1px solid #ddd;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            text-align: left;
            display: flex;
            flex-direction: column;
        }

        .project-item:hover {
            transform: translateY(-8px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
        }

        .project-item img {
            max-width: 100%;
            height: auto;
            border-radius: 10px;
            margin-bottom: 20px;
            border: 1px solid #eee;
            display: block; /* Ensures it takes up full width of parent */
        }

        .project-item h3 {
            font-size: 1.8em;
            color: #00bcd4;
            margin-bottom: 15px;
        }

        .project-item p {
            font-size: 1em;
            margin-bottom: 15px;
            flex-grow: 1;
        }

        .project-item strong {
            display: block;
            margin-top: 10px;
            margin-bottom: 10px;
            color: #555;
        }

        .project-links {
            margin-top: 20px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .project-links .btn {
            background: linear-gradient(45deg, #00bcd4, #0097a7);
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 188, 212, 0.3);
            white-space: nowrap;
            cursor: pointer; /* Indicate it's clickable */
        }

        .project-links .btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 188, 212, 0.5);
            background: linear-gradient(45deg, #0097a7, #00bcd4);
        }

        /* Modal Styling */
        .modal {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 2000; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgba(0,0,0,0.8); /* Black w/ opacity */
            justify-content: center;
            align-items: center;
            animation: fadeIn 0.3s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto; /* Center modal */
            padding: 20px;
            border: 1px solid #888;
            width: 90%;
            max-width: 800px; /* Max width for video */
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            position: relative;
            animation: slideIn 0.3s ease-out;
        }

        @keyframes slideIn {
            from { transform: translateY(-50px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .modal-content video {
            width: 100%;
            height: auto;
            max-height: 70vh; /* Limit video height */
            display: block;
            margin: 0 auto;
            border-radius: 10px;
        }

        .close-button {
            color: #aaa;
            font-size: 35px;
            font-weight: bold;
            position: absolute;
            top: 10px;
            right: 20px;
            cursor: pointer;
            transition: color 0.3s ease;
        }

        .close-button:hover,
        .close-button:focus {
            color: #00bcd4;
            text-decoration: none;
            cursor: pointer;
        }

        /* Footer */
        footer {
            background: #222;
            color: #fff;
            text-align: center;
            padding: 2rem 0;
            margin-top: 40px;
            border-top-left-radius: 10px;
            border-top-right-radius: 10px;
            box-shadow: 0 -2px 5px rgba(0,0,0,0.2);
        }

        footer p {
            margin-bottom: 15px;
            font-size: 0.9em;
            opacity: 0.8;
        }

        .social-links a {
            color: #fff;
            margin: 0 15px;
            text-decoration: none;
            font-size: 1.2em;
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .social-links a:hover {
            color: #00bcd4;
            transform: translateY(-3px);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                padding: 0 20px;
            }

            nav .logo h1 {
                margin-bottom: 10px;
            }

            nav ul {
                flex-direction: column;
                width: 100%;
                text-align: center;
            }

            nav ul li {
                margin: 5px 0;
            }

            #projects-list {
                padding: 40px 15px;
            }

            .project-grid {
                grid-template-columns: 1fr;
            }

            .project-item h3 {
                font-size: 1.5em;
            }

            .project-links {
                justify-content: center;
            }

            .modal-content {
                width: 95%;
                padding: 15px;
            }

            .close-button {
                font-size: 30px;
                top: 5px;
                right: 15px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>Jacob Ginono Mwita</h1>
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="projects.php" class="active">Projects</a></li>
                <li><a href="about.php">About Me</a></li>
                <li><a href="contact.php">Contact</a></li>
                 <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <li><a href="index.php#messages-section">Messages</a></li>
                <?php endif; ?>
            </ul>
            <div class="auth-buttons">
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <a href="logout.php" class="btn-auth">Logout</a>
                <?php else: ?>
                    <a href="login.php" class="btn-auth">Login (Owner)</a>
                <?php endif; ?>
            </div>
        </nav>
    </header>

    <main>
        <section id="projects-list" class="container">
            <h2>My Projects</h2>

            <div class="project-grid">
                <!-- Project Item 1: Full-Stack E-commerce Platform (PHP/SQL) -->
                <div class="project-item">
                    <img src="images/E-commerce Project Screenshot.png" alt="E-commerce Project Screenshot.png">
                    <h3>E-commerce Platform</h3>
                    <p>A comprehensive full-stack e-commerce solution with user authentication, product catalog management, shopping cart functionality, and order processing. Built for scalability and secure transactions.</p>
                    <p><strong>Technologies:</strong> PHP, MySQL, HTML, CSS, JavaScript (AJAX)</p>
                    <div class="project-links">
                        <a href="https://github.com/Jacobmwita/E_commerce-project" target="_blank" rel="noopener noreferrer" class="btn">View Code</a>
                        <button class="btn open-modal" data-video-src="videos/ecommerce demo.mp4">Live Demo</button>
                    </div>
                </div>

                <!-- Project Item 2: Automotive Workshop Management System -->
                <div class="project-item">
                    <img src="images/workshop.png" alt="Automotive Workshop Management System Screenshot">
                    <h3>An Automotive Workshop Management System</h3>
                    <p>An interactive and friendly Workshop management system that enables the management of all activities within the Workshop, provides easy access to workshop reports and financial monitoring. Features include adding, deleting, marking as complete of the jobs, and filtering tasks. It also gives admin a chance to oversee all activities within the workshop including inventories monitoring.</p>
                    <p><strong>Technologies:</strong> HTML5, CSS3, Vanilla JavaScript</p>
                    <div class="project-links">
                        <a href="https://github.com/your-github-username/workshop-system" target="_blank" rel="noopener noreferrer" class="btn">View Code</a>
                        <button class="btn open-modal" data-video-src="videos/workshop_demo.mp4">Live Demo</button>
                    </div>
                </div>

                <!-- Project Item 3: Dynamic Hotel Rooms Booking System -->
                <div class="project-item">
                    <img src="images/hotel.png" alt="Dynamic Hotel Rooms Booking System Screenshot">
                    <h3>Dynamic Hotel Rooms Booking System</h3>
                    <p>A Dynamic management system for Hotel Rooms Booking, allowing users to hover, book, and get approvals on their room bookings. The system enables staff to manage customers and also monitor the progress of the rooms within the Hotel. Includes an admin panel for system moderation.</p>
                    <p><strong>Technologies:</strong> PHP, MySQL, HTML, CSS</p>
                    <div class="project-links">
                        <a href="https://github.com/your-github-username/hotel-booking-system" target="_blank" rel="noopener noreferrer" class="btn">View Code</a>
                        <button class="btn open-modal" data-video-src="videos/hotel_demo.mp4">Live Demo</button>
                    </div>
                </div>

                <!-- Project Item 4: Responsive Landing Page (HTML/CSS) - Keeping it simple with image, still with a live demo button -->
                <div class="project-item">
                    <img src="https://placehold.co/400x250/b0e0e6/333333?text=Landing+Page+Screenshot" alt="Landing Page Project Screenshot">
                    <h3>Responsive Landing Page</h3>
                    <p>A modern and fully responsive landing page design, demonstrating advanced CSS techniques like Flexbox and Grid, custom animations, and a focus on optimal user experience across devices.</p>
                    <p><strong>Technologies:</strong> HTML5, CSS3</p>
                    <div class="project-links">
                        <a href="https://github.com/your-github-username/responsive-landing-page" target="_blank" rel="noopener noreferrer" class="btn">View Code</a>
                        <!-- For a purely static project, a live demo might still be an external link, or you can make a short video for it -->
                        <button class="btn open-modal" data-video-src="videos/landing_page_demo.mp4">Live Demo</button>
                    </div>
                </div>

                <!-- Add more project items here following the same structure -->

            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Jacob. All rights reserved.</p>
        <div class="social-links">
            <a href="https://github.com/Jacobmwita" target="_blank" rel="noopener noreferrer">GitHub</a>
            <a href="https://www.linkedin.com/in/jacob-mwita-0632b7364/" target="_blank" rel="noopener noreferrer">LinkedIn</a>
        </div>
    </footer>

    <!-- The Modal Structure (initially hidden) -->
    <div id="videoModal" class="modal">
        <div class="modal-content">
            <span class="close-button">&times;</span>
            <video id="projectVideo" controls autoplay muted preload="auto">
                Your browser does not support the video tag.
            </video>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('projects.php loaded successfully!');

            // --- Navigation Active Link Logic ---
            const currentPath = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('nav ul li a');
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                const hrefFileName = href.split('/').pop();
                if (hrefFileName === currentPath || (currentPath === '' && hrefFileName === 'index.php')) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });

            // --- Modal Video Demo Logic ---
            const videoModal = document.getElementById('videoModal');
            const projectVideo = document.getElementById('projectVideo');
            const closeButton = document.querySelector('.close-button');
            const openModalButtons = document.querySelectorAll('.open-modal');

            // Function to open the modal
            openModalButtons.forEach(button => {
                button.addEventListener('click', () => {
                    const videoSrc = button.getAttribute('data-video-src');
                    if (videoSrc) {
                        // Set the video source
                        projectVideo.src = videoSrc;
                        // Display the modal
                        videoModal.style.display = 'flex'; // Use flex to center
                        // Load and play the video
                        projectVideo.load();
                        projectVideo.play();
                    }
                });
            });

            // Function to close the modal
            closeButton.addEventListener('click', () => {
                videoModal.style.display = 'none';
                projectVideo.pause(); // Pause video when modal closes
                projectVideo.currentTime = 0; // Reset video to beginning
            });

            // Close the modal if user clicks outside of the video content
            window.addEventListener('click', (event) => {
                if (event.target === videoModal) {
                    videoModal.style.display = 'none';
                    projectVideo.pause();
                    projectVideo.currentTime = 0;
                }
            });
        });
    </script>
</body>
</html>
