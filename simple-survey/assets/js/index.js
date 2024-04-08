jQuery(document).ready(function ($) {
  let answerCounts = {}; // To keep track of selections for each redirect URL

  // Common function to handle both Yes and No button clicks
  function handleAnswerButtonClick(button) {
    let redirectUrl = button.data("redirect-url");
    let isDecisive = button.data("is-decisive") === "yes";

    // If it's a decisive "Yes" answer, redirect immediately
    if (isDecisive && button.hasClass("yes-btn") && redirectUrl) {
      window.location.href = redirectUrl;
      return; // Stop further execution
    }

    // Increment the count for the selected redirect URL for non-decisive questions
    if (redirectUrl) {
      answerCounts[redirectUrl] = (answerCounts[redirectUrl] || 0) + 1;
    }

    let currentQuestion = button.closest(".elementor-survey__question");
    let nextQuestion = currentQuestion.next(".elementor-survey__question");

    currentQuestion.hide();
    if (nextQuestion.length) {
      nextQuestion.show(); // Show the next question if it exists
    } else {
      // Decide on redirection based on the most chosen URL at the end of the survey
      let mostChosenUrl = Object.keys(answerCounts).reduce(
        (a, b) => (answerCounts[a] > answerCounts[b] ? a : b),
        Object.keys(answerCounts)[0] // Default to the first URL if no selections
      );

      if (mostChosenUrl) {
        window.location.href = mostChosenUrl; // Redirect to the most chosen URL
      }
    }
  }

  // Click event delegation for Yes and No buttons
  $(document).on("click", ".yes-btn, .no-btn", function () {
    handleAnswerButtonClick($(this));
  });

  // Click event delegation for the Previous button
  $(document).on("click", ".survey-prev-btn", function () {
    var currentQuestion = $(this).closest(".elementor-survey__question");
    currentQuestion.hide();
    currentQuestion.prev(".elementor-survey__question").show();
  });

  // Initially, show only the first question
  $(".elementor-survey__question").hide().first().show();
});
