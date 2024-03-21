jQuery(document).ready(function ($) {
  let answerCounts = {}; // To keep track of selections for each redirect URL

  // Common function to handle both Yes and No button clicks
  function handleAnswerButtonClick(button) {
    let redirectUrl = button.data("redirect-url");

    // Increment the count for the selected redirect URL
    if (redirectUrl) {
      answerCounts[redirectUrl] = (answerCounts[redirectUrl] || 0) + 1;
    }

    // Move to the next question or redirect if this is the last question
    let currentQuestion = button.closest(".elementor-survey__question");
    let nextQuestion = currentQuestion.next(".elementor-survey__question");

    currentQuestion.hide();
    if (nextQuestion.length) {
      nextQuestion.show(); // Show the next question if it exists
    } else {
      // Last question was answered, decide on redirection
      let mostChosenUrl = Object.keys(answerCounts).reduce(
        (a, b) => (answerCounts[a] > answerCounts[b] ? a : b),
        Object.keys(answerCounts)[0] // Default to the first URL if no selections
      );

      if (mostChosenUrl) {
        window.location.href = mostChosenUrl; // Redirect to the most chosen URL
      }
    }
  }

  // Click event for Yes and No buttons
  $(".yes-btn, .no-btn").click(function () {
    handleAnswerButtonClick($(this));
  });

  // Click previous button
  $(".survey-prev-btn").click(function () {
    var currentQuestion = $(this).closest(".elementor-survey__question");
    currentQuestion.hide();
    currentQuestion.prev(".elementor-survey__question").show();
  });

  // Initially, show only the first question
  $(".elementor-survey__question").hide().first().show();

  $(document).on("click", ".yes-btn, .no-btn", function () {
    handleAnswerButtonClick($(this));
  });

  $(document).on("click", ".survey-prev-btn", function () {
    var currentQuestion = $(this).closest(".elementor-survey__question");
    currentQuestion.hide();
    currentQuestion.prev(".elementor-survey__question").show();
  });
});
