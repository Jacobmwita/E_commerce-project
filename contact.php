<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact - Jacob's Portfolio</title>
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

        /* Contact Section */
        #contact-section {
            padding: 60px 20px;
            background-color: #fff;
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 40px;
            margin-bottom: 40px;
            text-align: center;
        }

        #contact-section h2 {
            font-size: 2.5em;
            color: #222;
            margin-bottom: 30px;
        }

        .contact-form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #f9f9f9;
            border-radius: 15px;
            padding: 30px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            text-align: left;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
            color: #555;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group textarea {
            width: calc(100% - 20px);
            padding: 12px 10px;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1em;
            transition: border-color 0.3s ease, box-shadow 0.3s ease;
        }

        .form-group input[type="text"]:focus,
        .form-group input[type="email"]:focus,
        .form-group textarea:focus {
            border-color: #00bcd4;
            box-shadow: 0 0 8px rgba(0, 188, 212, 0.2);
            outline: none;
        }

        .form-group textarea {
            resize: vertical;
            min-height: 120px;
        }

        .submit-btn {
            display: block;
            width: 100%;
            background: linear-gradient(45deg, #00bcd4, #0097a7);
            color: #fff;
            padding: 15px 25px;
            border: none;
            border-radius: 30px;
            font-size: 1.1em;
            font-weight: bold;
            cursor: pointer;
            transition: transform 0.3s ease, box-shadow 0.3s ease, background 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 188, 212, 0.4);
        }

        .submit-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(0, 188, 212, 0.6);
            background: linear-gradient(45deg, #0097a7, #00bcd4);
        }

        .message-box {
            margin-top: 20px;
            padding: 15px;
            border-radius: 8px;
            font-weight: bold;
            text-align: center;
            display: none;
            transition: opacity 0.5s ease;
        }

        .message-box.success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message-box.error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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

            #contact-section {
                padding: 40px 15px;
            }

            .contact-form-container {
                padding: 20px;
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
                <li><a href="about.php">About Me</a></li>
                <li><a href="contact.php" class="active">Contact</a></li>
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
        <section id="contact-section" class="container">
            <h2>Get in Touch</h2>
            <p>Have a question or a project in mind? Feel free to send me a message!</p>

            <div class="contact-form-container">
                <form id="contactForm" action="php/contact_process.php" method="POST">
                    <div class="form-group">
                        <label for="name">Name:</label>
                        <input type="text" id="name" name="name" required placeholder="Your Name">
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="email" id="email" name="email" required placeholder="your.email@example.com">
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject:</label>
                        <input type="text" id="subject" name="subject" placeholder="Project Inquiry, Collaboration, etc.">
                    </div>
                    <div class="form-group">
                        <label for="message">Message:</label>
                        <textarea id="message" name="message" required placeholder="Your message..."></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
                <div id="messageBox" class="message-box" style="opacity: 0;"></div>
            </div>
        </section>
    </main>

    <footer>
        <p>&copy; 2025 Jacob. All rights reserved.</p>
        <div class="social-links">
            <a href="https://github.com/your-github-username" target="_blank" rel="noopener noreferrer">GitHub</a>
            <a href="https://linkedin.com/in/your-linkedin-username" target="_blank" rel="noopener noreferrer">LinkedIn</a>
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('contact.php loaded successfully!');

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

            const urlParams = new URLSearchParams(window.location.search);
            const status = urlParams.get('status');
            const msg = urlParams.get('msg');
            const messageBox = document.getElementById('messageBox');

            if (status && msg) {
                messageBox.textContent = decodeURIComponent(msg);
                messageBox.style.display = 'block';
                messageBox.style.opacity = '1';
                if (status === 'success') {
                    messageBox.classList.add('success');
                    messageBox.classList.remove('error');
                    document.getElementById('contactForm').reset();
                } else {
                    messageBox.classList.add('error');
                    messageBox.classList.remove('success');
                }
                setTimeout(() => {
                    messageBox.style.opacity = '0';
                    setTimeout(() => {
                        messageBox.style.display = 'none';
                    }, 500);
                }, 5000);
            }
        });
    </script>
</body>
</html>
