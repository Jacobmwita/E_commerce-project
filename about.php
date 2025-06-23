<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Me - Jacob's Portfolio</title>
    <style>
        /* General Styling (repeated for self-contained files) */
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
        }

        nav ul li {
            margin-left: 25px;
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

        /* About Me Content */
        #about-content {
            padding: 60px 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 40px;
            margin-bottom: 40px;
        }

        #about-content h2 {
            font-size: 2.5em;
            color: #222;
            text-align: center;
            margin-bottom: 30px;
        }

        .bio-section {
            display: flex;
            flex-wrap: wrap; /* Allows wrapping on smaller screens */
            gap: 40px;
            align-items: flex-start;
            margin-bottom: 50px;
        }

        .bio-text {
            flex: 2;
            min-width: 300px; /* Ensures text block has a minimum width */
        }

        .bio-text p {
            font-size: 1.1em;
            line-height: 1.8;
            margin-bottom: 20px;
        }

        .profile-card {
            flex: 1;
            min-width: 250px; /* Ensures card has a minimum width */
            background-color: #e0f7fa;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: center;
            border: 1px solid #00bcd4;
        }

        .profile-card img {
            width: 150px;
            height: 150px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #00bcd4;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 188, 212, 0.4);
        }

        .profile-card h3 {
            font-size: 1.5em;
            color: #222;
            margin-bottom: 10px;
        }

        .profile-card p {
            font-size: 1em;
            color: #555;
            margin-bottom: 5px;
        }

        .skills-section {
            margin-top: 50px;
        }

        .skills-section h3 {
            font-size: 2em;
            color: #222;
            text-align: center;
            margin-bottom: 30px;
        }

        .skills-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 20px;
            text-align: center;
        }

        .skill-item {
            background-color: #f0f8ff;
            border: 1px solid #cceeff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .skill-item:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.15);
        }

        .skill-item h4 {
            font-size: 1.2em;
            color: #00bcd4;
            margin-bottom: 10px;
        }

        .skill-item ul {
            list-style: none;
            padding: 0;
        }

        .skill-item ul li {
            font-size: 0.95em;
            color: #555;
            margin-bottom: 5px;
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

            #about-content {
                padding: 40px 15px;
            }

            .bio-section {
                flex-direction: column;
                align-items: center;
            }

            .bio-text, .profile-card {
                min-width: unset;
                width: 100%;
            }

            .skills-grid {
                grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>Jacob</h1>
            </div>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="about.php" class="active">About Me</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </nav>
    </header>

    <main>
        <section id="about-content" class="container">
            <h2>About Jacob</h2>

            <div class="bio-section">
                <div class="bio-text">
                    <p>
                        Hello! I'm Jacob, a versatile Full-Stack Software Developer with a deep passion for crafting efficient, scalable, and user-friendly web applications. My journey into the world of code began several years ago, driven by a desire to understand and build the digital tools that shape our modern world.
                    </p>
                    <p>
                        I specialize in bringing ideas to life, from conceptualization and design to robust back-end implementation and seamless database integration. My expertise spans across front-end technologies like HTML, CSS, and JavaScript for engaging user interfaces, to powerful back-end development with PHP, ensuring reliable server-side logic and data management with SQL databases.
                    </p>
                    <p>
                        I believe in continuous learning and adapting to new technologies. I enjoy tackling complex challenges and am always looking for opportunities to contribute to meaningful projects. When I'm not coding, you might find me exploring new tech trends, contributing to open-source, or perhaps enjoying a good book.
                    </p>
                    <p>
                        I'm eager to connect and discuss how my skills can help bring your next project to fruition!
                    </p>
                </div>
                <div class="profile-card">
                    <img src="images/Jacob's Profile Picture.jpg" alt="Jacob's Profile Picture.jpg">
                    <h3>Jacob Ginono Mwita.</h3>
                    <p>Full-Stack Developer</p>
                    <p>Based in Meru, Kenya</p>
                    <p>Contact: <a href="mailto:your.jacobmwita30@gmail.com" style="color: #00bcd4; text-decoration: none;">+254707846323 or +254708723720</a></p>

                    <p>Email: <a href="mailto:your.jacobmwita30@gmail.com" style="color: #00bcd4; text-decoration: none;">jacobmwita30@gmail.com</a></p>
                    <div class="social-links" style="margin-top: 15px;">
                        <a href="https://github.com/Jacobmwita" target="_blank" rel="noopener noreferrer" style="font-size: 1em; margin: 0 8px;"><!-- Optional: Add GitHub icon here --> GitHub</a>
                        <a href="https://www.linkedin.com/in/jacob-mwita-0632b7364/" target="_blank" rel="noopener noreferrer" style="font-size: 1em; margin: 0 8px;"><!-- Optional: Add LinkedIn icon here --> LinkedIn</a>
                    </div>
                </div>
            </div>

            <div class="skills-section">
                <h3>My Technical Skills</h3>
                <div class="skills-grid">
                    <div class="skill-item">
                        <h4>Front-End</h4>
                        <ul>
                            <li>HTML5</li>
                            <li>CSS3</li>
                            <li>JavaScript (ES6+)</li>
                            <li>Responsive Design</li>
                            <li>UI/UX Principles</li>
                        </ul>
                    </div>
                    <div class="skill-item">
                        <h4>Back-End</h4>
                        <ul>
                            <li>PHP</li>
                            <li>RESTful APIs</li>
                            <li>Authentication & Authorization</li>
                            <li>Server Management</li>
                        </ul>
                    </div>
                    <div class="skill-item">
                        <h4>Databases</h4>
                        <ul>
                            <li>SQL (MySQL)</li>
                            <li>Database Design</li>
                            <li>Query Optimization</li>
                        </ul>
                    </div>
                    <div class="skill-item">
                        <h4>Tools & Concepts</h4>
                        <ul>
                            <li>Git & GitHub</li>
                            <li>VS Code</li>
                            <li>Object-Oriented Programming (OOP)</li>
                            <li>Problem Solving</li>
                        </ul>
                    </div>
                    <!-- Add more skill items as needed -->
                </div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Jacob. All rights reserved.</p>
        <div class="social-links">
            <a href="https://github.com/your-github-Jacobmwita" target="_blank" rel="noopener noreferrer">GitHub</a>
            <a href="https://www.linkedin.com/in/jacob-mwita-0632b7364/" target="_blank" rel="noopener noreferrer">LinkedIn</a>
        </div>
    </footer>

    <script>
        // JavaScript for about.html
        document.addEventListener('DOMContentLoaded', () => {
            console.log('about.html loaded successfully!');

            // Basic active link highlighting
            const currentPath = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('nav ul li a');
            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');
                } else {
                    link.classList.remove('active');
                }
            });
        });
    </script>
</body>
</html>
