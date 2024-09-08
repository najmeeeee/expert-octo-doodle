<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Review Page</title>
    <style>
        /* Add a subtle gradient background */
        body {
            background: linear-gradient(135deg, #f3f3f3, #e2e2e2);
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        /* Style the review container */
        .review-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            background: rgba(255, 255, 255, 0.9);
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        h1 {
            color: #333;
            text-align: center;
        }

        /* Style the reviews section */
        .reviews {
            margin-bottom: 2rem;
        }

        .review {
            padding: 1rem;
            margin-bottom: 1rem;
            background: #fff;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }

        .review .name {
            font-weight: bold;
            color: #555;
        }

        .review .rating {
            color: #f5b301; /* Star color */
            font-size: 20px;
        }

        .review .text {
            font-style: italic;
            color: #666;
        }

        /* Style the review form */
        form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        textarea {
            padding: 0.5rem;
            font-size: 16px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        .rating-container {
            display: flex;
            gap: 0.5rem;
        }

        .rating-container input[type="radio"] {
            display: none;
        }

        .rating-container label {
            font-size: 24px;
            cursor: pointer;
            color: #f5b301;
        }

        .rating-container input[type="radio"]:checked + label {
            color: #f5b301; /* Highlight color for selected star */
        }

        button {
            padding: 0.5rem 1rem;
            font-size: 16px;
            background-color: #28a745;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s, transform 0.3s;
        }

        button:hover {
            background-color: #218838;
            transform: scale(1.05);
        }

        /* Error and success messages */
        p {
            text-align: center;
            margin-top: 1rem;
        }

        .error {
            color: red;
            font-weight: bold;
        }

        .success {
            color: green;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="backdrop"></div>

    <div class="review-container">
        <h1>Customer Reviews</h1>
        <div class="reviews">
            <?php
            // Your PHP code for fetching and displaying reviews
            ?>
        </div>

        <h2>Leave a Review</h2>
        <form action="" method="POST" id="reviewForm">
            <textarea name="review_text" id="review" placeholder="Your Review" required></textarea>

            <div class="rating-container">
                <input type="radio" id="star5" name="rating" value="5">
                <label for="star5">★</label>
                <input type="radio" id="star4" name="rating" value="4">
                <label for="star4">★</label>
                <input type="radio" id="star3" name="rating" value="3">
                <label for="star3">★</label>
                <input type="radio" id="star2" name="rating" value="2">
                <label for="star2">★</label>
                <input type="radio" id="star1" name="rating" value="1">
                <label for="star1">★</label>
            </div>

            <button type="submit">Submit Review</button>
        </form>
    </div>
</body>
</html>
