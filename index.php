<?php
session_start(); // Start the PHP session at the very beginning of the file

$servername = "sql309.infinityfree.com";
$username_db = "if0_39300768";
$password_db = "jdFPQTdFVtaEszn";
$dbname = "if0_39300768_portfolio_db";

$conn = new mysqli($servername, $username_db, $password_db, $dbname);

// Check DB connection
if ($conn->connect_error) {
    $db_connection_error = "Database connection failed: " . $conn->connect_error;
} else {
    $db_connection_error = null;
}

$unread_messages = [];
if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true && !$db_connection_error) {
    $sql_unread = "SELECT id, name, email, subject, message, submission_date FROM contacts WHERE is_read = FALSE ORDER BY submission_date DESC";
    $result_unread = $conn->query($sql_unread);
    if ($result_unread) {
        while ($row = $result_unread->fetch_assoc()) {
            $unread_messages[] = $row;
        }
    } else {
        error_log("Error fetching unread messages: " . $conn->error);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Jacob - Full-Stack Developer Portfolio</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
            margin: 0;
            padding: 0;
            /* Brighter, subtle background with a gradient for visual interest */
            background: linear-gradient(135deg, #e0f2f7 0%, #ffffff 50%, #f0f4f7 100%);
            color: #333;
            scroll-behavior: smooth;
            animation: fadeInBackground 1s ease-out forwards; /* Fade in background */
        }

        @keyframes fadeInBackground {
            from { opacity: 0; }
            to { opacity: 1; }
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
            background: rgba(34, 34, 34, 0.95); /* Slightly transparent dark header */
            color: #fff;
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 15px rgba(0,0,0,0.25); /* Stronger shadow */
            border-bottom-left-radius: 15px; /* More rounded */
            border-bottom-right-radius: 15px;
            backdrop-filter: blur(5px); /* Frosted glass effect */
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
            color: #00bcd4; /* Accent color */
            font-size: 2em; /* Slightly larger */
            letter-spacing: 1.5px;
            text-shadow: 1px 1px 3px rgba(0, 188, 212, 0.5); /* Subtle shadow */
        }

        nav ul {
            list-style: none;
            display: flex;
            margin: 0;
            padding: 0;
            align-items: center;
        }

        nav ul li {
            margin-left: 30px; /* More space */
            position: relative;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
            padding: 10px 18px; /* Larger hit area */
            transition: all 0.3s ease;
            border-radius: 20px; /* Very rounded pills */
            font-weight: 600; /* Bolder font */
            text-transform: uppercase; /* Uppercase for nav items */
            font-size: 0.95em;
        }

        nav ul li a:hover, nav ul li a.active {
            background-color: #00bcd4;
            color: #222;
            box-shadow: 0 6px 15px rgba(0, 188, 212, 0.4);
            transform: translateY(-2px); /* Slight lift */
        }

        .notification-badge {
            background-color: #ff4d4d;
            color: white;
            border-radius: 50%;
            padding: 5px 9px; /* Slightly larger badge */
            font-size: 0.75em;
            position: absolute;
            top: -10px; /* Adjusted position */
            right: -10px; /* Adjusted position */
            min-width: 22px;
            text-align: center;
            line-height: 1;
            box-shadow: 0 2px 5px rgba(0,0,0,0.3); /* Badge shadow */
            animation: pulse 1.5s infinite; /* Pulsing effect */
        }

        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .auth-buttons {
            display: flex;
            gap: 15px; /* More space */
            margin-left: 30px;
        }

        .auth-buttons .btn-auth {
            background: linear-gradient(45deg, #00bcd4, #0097a7); /* Gradient button */
            color: #fff;
            padding: 10px 20px;
            text-decoration: none;
            border-radius: 25px; /* More rounded */
            transition: all 0.3s ease;
            font-weight: bold;
            box-shadow: 0 4px 10px rgba(0, 188, 212, 0.3);
        }

        .auth-buttons .btn-auth:hover {
            background: linear-gradient(45deg, #0097a7, #00bcd4);
            transform: translateY(-2px);
            box-shadow: 0 6px 15px rgba(0, 188, 212, 0.5);
        }

        /* Hero Section */
        #hero {
            /* Brighter background image with a subtle pattern */
            background: linear-gradient(rgba(0,0,0,0.4), rgba(0,0,0,0.4)), url('https://placehold.co/1920x1080/64b5f6/ffffff/png?text=Abstract+Tech+Background') no-repeat center center/cover;
            color: #fff;
            min-height: 80vh; /* Taller hero section */
            display: flex;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 50px 20px;
            border-bottom-left-radius: 25px; /* More prominent rounding */
            border-bottom-right-radius: 25px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.4); /* Stronger shadow for depth */
            animation: fadeInHero 1s ease-out 0.5s forwards; /* Delayed fade in */
            opacity: 0; /* Start hidden for animation */
        }

        @keyframes fadeInHero {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-content {
            max-width: 900px; /* Wider content area */
            padding: 40px; /* More padding */
            background: rgba(0,0,0,0.5); /* Slightly less opaque overlay for background to show */
            border-radius: 20px; /* More rounded */
            box-shadow: 0 0 30px rgba(0,0,0,0.7); /* Deeper shadow */
            animation: scaleIn 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275) 1s forwards; /* Bounce-in animation */
            transform: scale(0.9); /* Start smaller */
            opacity: 0; /* Start hidden for animation */
        }

        @keyframes scaleIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        #hero h2 {
            font-size: 4.5em; /* Larger heading */
            margin-bottom: 15px;
            color: #00e5ff; /* Brighter accent for main heading */
            text-shadow: 3px 3px 6px rgba(0,0,0,0.8);
            letter-spacing: 2px;
        }

        #hero h3 {
            font-size: 2.5em; /* Larger subheading */
            margin-bottom: 30px;
            color: #b3e5fc; /* Lighter accent color */
            text-shadow: 1px 1px 3px rgba(0,0,0,0.6);
        }

        #hero p {
            font-size: 1.4em; /* Larger text */
            margin-bottom: 50px;
            opacity: 0.95;
            max-width: 700px;
            margin-left: auto;
            margin-right: auto;
        }

        .btn {
            display: inline-block;
            background: linear-gradient(45deg, #00bcd4, #0097a7);
            color: #fff;
            padding: 15px 35px; /* Larger button */
            text-decoration: none;
            border-radius: 35px; /* Even more rounded */
            transition: all 0.3s ease;
            font-weight: bold;
            letter-spacing: 1px;
            box-shadow: 0 8px 20px rgba(0, 188, 212, 0.5); /* Deeper shadow */
            animation: fadeInButton 0.8s ease-out 1.5s forwards; /* Delayed fade in */
            opacity: 0; /* Start hidden for animation */
        }

        @keyframes fadeInButton {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .btn:hover {
            transform: translateY(-5px) scale(1.02); /* More pronounced lift and slight scale */
            box-shadow: 0 12px 30px rgba(0, 188, 212, 0.7);
            background: linear-gradient(45deg, #0097a7, #00bcd4);
        }

        /* About Me / Picture Section */
        #about-me-intro {
            padding: 80px 30px; /* More padding */
            text-align: center;
            background-color: #ffffff; /* Pure white for contrast */
            border-radius: 20px; /* More rounded */
            box-shadow: 0 10px 30px rgba(0,0,0,0.1); /* Stronger shadow */
            margin-top: 60px; /* More margin */
            margin-bottom: 60px;
            border-top: 5px solid #00bcd4; /* Accent top border */
            position: relative; /* For potential animations */
        }

        #about-me-intro h2 {
            font-size: 3em; /* Larger heading */
            color: #1a1a1a; /* Darker for strong contrast */
            margin-bottom: 40px;
            position: relative;
        }

        #about-me-intro h2::after { /* Underline effect */
            content: '';
            display: block;
            width: 80px;
            height: 4px;
            background-color: #00bcd4;
            margin: 15px auto 0;
            border-radius: 2px;
        }

        .profile-section {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 50px; /* More space between elements */
            max-width: 1000px; /* Wider section */
            margin: 0 auto;
            animation: slideInUp 0.8s ease-out forwards; /* Animation for profile section */
            opacity: 0;
            transform: translateY(20px);
        }

        @keyframes slideInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }


        .profile-picture-container {
            width: 250px; /* Larger picture */
            height: 250px;
            border-radius: 50%;
            overflow: hidden;
            border: 8px solid #00bcd4; /* Thicker border */
            box-shadow: 0 0 25px rgba(0, 188, 212, 0.6); /* More prominent shadow */
            flex-shrink: 0;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .profile-picture-container:hover {
            transform: scale(1.05) rotate(2deg); /* Subtle rotate on hover */
            box-shadow: 0 0 35px rgba(0, 188, 212, 0.8);
        }

        .profile-picture-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            display: block;
        }

        .profile-text {
            text-align: left;
            max-width: 700px; /* Wider text block */
        }

        .profile-text p {
            font-size: 1.2em; /* Larger text */
            line-height: 1.9; /* More line spacing */
            margin-bottom: 25px;
            color: #444; /* Slightly softer text color */
        }

        /* Messages Section */
        #messages-section {
            padding: 60px 20px;
            background-color: #ffffff; /* Pure white */
            border-radius: 15px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
            margin-top: 40px;
            margin-bottom: 40px;
        }

        #messages-section h2 {
            font-size: 2.5em;
            color: #222;
            text-align: center;
            margin-bottom: 30px;
        }

        .message-list {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .message-item {
            background-color: #f0faff; /* Very light blue background for messages */
            border: 1px solid #cceeff;
            border-left: 6px solid #00bcd4; /* Thicker accent line for unread */
            border-radius: 12px; /* More rounded */
            padding: 25px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.1);
            position: relative;
            transition: all 0.3s ease;
        }

        .message-item.read {
            border-left: 6px solid #a7d9d9; /* Softer accent for read */
            opacity: 0.9;
            background-color: #e0f2f7; /* Lighter background for read */
        }

        .message-item h3 {
            font-size: 1.6em;
            color: #222;
            margin-bottom: 12px;
            padding-bottom: 5px;
            border-bottom: 1px dashed rgba(0,0,0,0.1); /* Subtle separator */
        }

        .message-item p {
            margin-bottom: 10px;
            font-size: 1em;
            color: #444;
        }

        .message-item strong {
            color: #008c9e; /* Deeper accent for strong text */
        }

        .message-item .timestamp {
            font-size: 0.9em;
            color: #777;
            margin-top: 15px;
            display: block;
            text-align: right;
        }

        .message-actions {
            margin-top: 20px;
            display: flex;
            gap: 15px; /* More space between buttons */
            justify-content: flex-end;
        }

        .message-actions button {
            background: linear-gradient(45deg, #00bcd4, #0097a7);
            color: #fff;
            border: none;
            padding: 10px 20px; /* Larger buttons */
            border-radius: 25px; /* More rounded */
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: bold;
            box-shadow: 0 3px 8px rgba(0, 188, 212, 0.3);
        }

        .message-actions button.mark-read {
            background: linear-gradient(45deg, #28a745, #218838); /* Green gradient */
            box-shadow: 0 3px 8px rgba(40, 167, 69, 0.3);
        }

        .message-actions button.delete {
            background: linear-gradient(45deg, #dc3545, #c82333); /* Red gradient */
            box-shadow: 0 3px 8px rgba(220, 53, 69, 0.3);
        }

        .message-actions button:hover {
            transform: translateY(-2px);
            opacity: 0.95;
            box-shadow: 0 5px 12px rgba(0,0,0,0.2);
        }

        .no-messages {
            text-align: center;
            font-style: italic;
            color: #777;
            padding: 40px;
            border: 2px dashed #b0e0e6; /* Brighter dashed border */
            border-radius: 15px;
            background-color: #e0f7fa; /* Light background for no messages */
            font-size: 1.1em;
        }

        /* Footer */
        footer {
            background: #222;
            color: #fff;
            text-align: center;
            padding: 2.5rem 0; /* More padding */
            margin-top: 60px; /* More margin */
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            box-shadow: 0 -4px 15px rgba(0,0,0,0.25);
        }

        footer p {
            margin-bottom: 20px;
            font-size: 1em; /* Slightly larger text */
            opacity: 0.9;
        }

        .social-links a {
            color: #fff;
            margin: 0 20px; /* More space */
            text-decoration: none;
            font-size: 1.4em; /* Larger icons/text */
            transition: color 0.3s ease, transform 0.3s ease;
        }

        .social-links a:hover {
            color: #00bcd4;
            transform: translateY(-5px); /* More pronounced lift */
        }

        /* Responsive Design */
        @media (min-width: 768px) {
            .profile-section {
                flex-direction: row;
                text-align: left;
            }

            .profile-text {
                text-align: left;
            }
        }

        @media (max-width: 768px) {
            nav {
                flex-direction: column;
                padding: 0 20px;
            }

            nav .logo h1 {
                margin-bottom: 10px;
                font-size: 1.5em; /* Adjust for smaller screens */
            }

            nav ul {
                flex-direction: column;
                width: 100%;
                text-align: center;
            }

            nav ul li {
                margin: 8px 0; /* More vertical space */
            }

            nav ul li a {
                padding: 10px 15px; /* Adjust button size */
            }

            .auth-buttons {
                flex-direction: column;
                margin-top: 15px;
                margin-left: 0;
                width: 100%;
            }

            .auth-buttons .btn-auth {
                width: 80%; /* Make buttons wider */
                margin: 5px auto; /* Center them */
            }

            #hero {
                min-height: 60vh; /* Adjust height for mobile */
                padding: 30px 15px;
            }

            .hero-content {
                padding: 25px;
            }

            #hero h2 {
                font-size: 3em; /* Adjust font size */
            }

            #hero h3 {
                font-size: 1.8em;
            }

            #hero p {
                font-size: 1.1em;
            }

            .btn {
                padding: 12px 25px;
                font-size: 1em;
            }

            #about-me-intro, #messages-section {
                padding: 40px 15px;
                margin-top: 30px;
                margin-bottom: 30px;
            }

            #about-me-intro h2 {
                font-size: 2em;
            }

            .profile-picture-container {
                width: 180px; /* Slightly smaller picture */
                height: 180px;
            }

            .profile-text p {
                font-size: 1em;
            }

            #messages-section h2 {
                font-size: 2em;
            }

            .message-actions {
                flex-direction: column;
                align-items: stretch; /* Stretch buttons */
            }

            .message-actions button {
                width: 100%;
                margin: 5px 0; /* Vertical stack with margin */
            }

            footer {
                padding: 1.5rem 0;
            }

            .social-links a {
                font-size: 1.1em;
                margin: 0 10px;
            }
        }
    </style>
</head>
<body>
    <header>
        <nav>
            <div class="logo">
                <h1>Jacob Mwita</h1>
            </div>
            <ul>
                <li><a href="index.php" class="active">Home</a></li>
                <li><a href="projects.php">Projects</a></li>
                <li><a href="about.php">About Me</a></li>
                <li><a href="contact.php">Contact</a></li>
                <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
                    <li>
                        <a href="#messages-section">
                            Messages
                            <?php if (count($unread_messages) > 0): ?>
                                <span class="notification-badge"><?php echo count($unread_messages); ?></span>
                            <?php endif; ?>
                        </a>
                    </li>
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
        <!-- Hero Section -->
        <section id="hero">
            <div class="hero-content">
                <h2>Hi, I'm Jacob</h2>
                <h3>A Passionate Full-Stack Software Developer</h3>
                <p>Building robust and scalable web applications with HTML, CSS, JavaScript, PHP, and SQL. Let's create something amazing!</p>
                <a href="projects.php" class="btn">View My Work</a>
            </div>
        </section>

        <!-- About Me / Picture Section -->
        <section id="about-me-intro" class="container">
            <h2>A Little Bit About Me</h2>
            <div class="profile-section">
                <div class="profile-picture-container">
                    <!-- REPLACE THIS PLACEHOLDER IMAGE WITH YOUR OWN PICTURE (e.g., in an 'images' folder) -->
                    <img src="images/Jacob's Profile Picture.jpg" alt="Jacob's Profile Picture.jpg">
                </div>
                <div class="profile-text">
                    <p>
                        I am Jacob, a dedicated software developer with expertise across the full stack. My journey in development began with a curiosity for how things work, and it quickly evolved into a passion for building intuitive, efficient, and impactful digital solutions.
                    </p>
                    <p>
                        I thrive on solving complex problems and am always eager to learn new technologies and best practices. Whether it's crafting responsive front-end interfaces with HTML, CSS, and JavaScript, or developing robust back-end systems with PHP and managing data with SQL, I am committed to delivering high-quality code.
                    </p>
                    <p>
                        Explore my projects to see how I bring ideas to life!
                    </p>
                </div>
            </div>
        </section>

        <!-- Messages Section (Only visible to logged-in owner) -->
        <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
        <section id="messages-section" class="container">
            <h2>Your Messages</h2>
            <?php if ($db_connection_error): ?>
                <div class="message-box error" style="display: block; opacity: 1;">
                    <?php echo $db_connection_error; ?>
                </div>
            <?php elseif (empty($unread_messages) && $conn->query("SELECT COUNT(*) FROM contacts")->fetch_row()[0] == 0): ?>
                <p class="no-messages">No messages received yet.</p>
            <?php else: ?>
                <div class="message-list">
                    <?php if (empty($unread_messages)): ?>
                        <p class="no-messages">No new (unread) messages. All messages are marked as read or have been deleted.</p>
                    <?php else: ?>
                        <?php foreach ($unread_messages as $message): ?>
                            <div class="message-item" id="msg-<?php echo $message['id']; ?>">
                                <h3>Subject: <?php echo htmlspecialchars($message['subject'] ?: 'No Subject'); ?></h3>
                                <p><strong>From:</strong> <?php echo htmlspecialchars($message['name']); ?> (<?php echo htmlspecialchars($message['email']); ?>)</p>
                                <p><strong>Message:</strong> <?php echo nl2br(htmlspecialchars($message['message'])); ?></p>
                                <span class="timestamp">Received: <?php echo date("F j, Y, g:i a", strtotime($message['submission_date'])); ?></span>
                                <div class="message-actions">
                                    <form action="php/message_actions.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                        <button type="submit" name="action" value="mark_read" class="mark-read">Mark as Read</button>
                                    </form>
                                    <form action="php/message_actions.php" method="POST" style="display:inline;">
                                        <input type="hidden" name="message_id" value="<?php echo $message['id']; ?>">
                                        <button type="submit" name="action" value="delete" class="delete" onclick="return confirm('Are you sure you want to delete this message?');">Delete</button>
                                    </form>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>

                    <p class="no-messages" style="margin-top: 40px; border-style: solid; border-color: #b0e0e6; background-color: #f0faff; padding: 20px;">
                        This section currently only shows unread messages. For a full message inbox with all (read and unread) messages, you would typically build a dedicated "Admin Dashboard" or "Inbox" page, accessible only to you after logging in, with advanced features like pagination, search, and filtering.
                    </p>
                </div>
            <?php endif; ?>
        </section>
        <?php endif; ?>

    </main>

    <footer>
        <p>&copy; 2025 Jacob. All rights reserved.</p>
        <div class="social-links">
            <a href="https://github.com/Jacobmwita" target="_blank" rel="noopener noreferrer">GitHub</a>
            <a href="https://www.linkedin.com/in/jacob-mwita-0632b7364/" target="_blank" rel="noopener noreferrer">LinkedIn</a>
            <!-- Add other social links as needed, e.g.: -->
            <!-- <a href="https://twitter.com/your-twitter" target="_blank" rel="noopener noreferrer">Twitter</a> -->
        </div>
    </footer>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            console.log('index.php loaded successfully!');

            // Basic active link highlighting
            const currentPath = window.location.pathname.split('/').pop();
            const navLinks = document.querySelectorAll('nav ul li a');
            navLinks.forEach(link => {
                const href = link.getAttribute('href');
                let hrefFileName = href.split('/').pop();

                // Special handling for index.php as it's often the default or root
                if (hrefFileName === '' && link.textContent.trim() === 'Home') {
                    hrefFileName = 'index.php';
                }

                if (hrefFileName === currentPath || (currentPath === '' && hrefFileName === 'index.php')) {
                    link.classList.add('active');
                } else {
                    // Check if the link href is just a fragment (e.g., #messages-section)
                    // and if the current path is index.php, then mark "Messages" active.
                    if (href.startsWith('#') && currentPath === 'index.php' && link.textContent.trim().includes('Messages')) {
                        // This assumes the "Messages" link is only relevant on index.php
                        link.classList.add('active');
                    } else {
                        link.classList.remove('active');
                    }
                }
            });

            // Smooth scroll for internal links (like "Messages")
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function (e) {
                    e.preventDefault();
                    const targetId = this.getAttribute('href').substring(1);
                    const targetElement = document.getElementById(targetId);
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });
    </script>
</body>
</html>
