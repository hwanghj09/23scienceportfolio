<?php
session_start();

$quizFilePath = 'quiz.txt';
$answerFilePath = 'answer.txt';

function getRandomQuestion($quizFilePath, $answerFilePath) {
    $quizzes = file($quizFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $answers = file($answerFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($quizzes && $answers && count($quizzes) === count($answers)) {
        $randomIndex = array_rand($quizzes);
        $randomQuestion = $quizzes[$randomIndex];
        $_SESSION['current_question_index'] = $randomIndex;

        return $randomQuestion;
    }
    return null;
}

function checkAnswerAndUpdateScore($userAnswer, $currentQuestionIndex, $answerFilePath) {
    $answers = file($answerFilePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    if ($answers && isset($answers[$currentQuestionIndex])) {
        $correctAnswer = $answers[$currentQuestionIndex];

        if (strtolower($userAnswer) == strtolower($correctAnswer)) {
            $_SESSION['score']++;
            updateScore(base64_decode($_COOKIE['user_id']), $_SESSION['score']);
        }
    }
}

// Function to update the score in the database
function updateScore($userId, $score) {
    // Replace these values with your actual database credentials
    $dbHost = 'svc.sel4.cloudtype.app:32632';
    $dbUser = 'root';
    $dbPassword = 'qwaszx77^^';
    $dbName = 'quiz';

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to update the score
    $sql = "UPDATE users SET score = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $score, $userId);
    $stmt->execute();

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}

// Function to get the current score from the database
function getCurrentScore($userId) {
    // Replace these values with your actual database credentials
    $dbHost = 'svc.sel4.cloudtype.app:32632';
    $dbUser = 'root';
    $dbPassword = 'qwaszx77^^';
    $dbName = 'quiz';

    // Create a database connection
    $conn = new mysqli($dbHost, $dbUser, $dbPassword, $dbName);

    // Check for connection errors
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare and execute the SQL query to get the current score
    $sql = "SELECT score FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
    $stmt->execute();
    $stmt->bind_result($score);
    $stmt->fetch();

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    return $score;
}

// Initialize session if not already done
if (!isset($_SESSION['initialized'])) {
    $_SESSION['initialized'] = true;
    $userId = $_COOKIE['user_id'];
    $_SESSION['score'] = getCurrentScore($userId);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_answer'])) {
    $userAnswer = $_POST['user_answer'];
    $currentQuestionIndex = $_SESSION['current_question_index'];
    checkAnswerAndUpdateScore($userAnswer, $currentQuestionIndex, $answerFilePath);
}

$randomQuestion = getRandomQuestion($quizFilePath, $answerFilePath);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f0f0f0;
            color: #333;
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }

        .quiz-container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 80%;
            max-width: 600px;
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
        }

        form {
            margin-top: 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
        }

        input {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }

        button:hover {
            background-color: #45a049;
        }

        .score {
            margin-top: 20px;
            font-size: 18px;
        }
    </style>
    <title>퀴즈 페이지</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@10">
</head>
<body>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <div class="quiz-container">
        <h1>퀴즈 타임!</h1>

        <div>
            <?php
            if ($randomQuestion) {
                echo "<p><strong>문제:</strong> $randomQuestion</p>";

                echo '<form method="post">';
                echo '<label for="user_answer">정답:</label>';
                echo '<input type="text" name="user_answer" id="user_answer" required>';
                echo '<button type="submit">제출</button>';
                echo '</form>';
            } else {
                echo "<p>사용 가능한 퀴즈나 답이 없습니다.</p>";
            }
            ?>
        </div>

        <form method="post" action="index.php">
            <button type="submit">돌아가기</button>
        </form>

        <p class="score"><strong>점수:</strong> <?php echo $_SESSION['score']; ?></p>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function () {
            location.href = 'index.php';
        });
        
    </script>
</body>
</html>
