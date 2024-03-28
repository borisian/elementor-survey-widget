jQuery(document).ready(function ($) {
  let answerCounts = {}; // To keep track of selections for each redirect URL
  let decisiveUrl = ""; // To store the redirect URL of a decisive question if answered "Yes"

  // Common function to handle both Yes and No button clicks
  function handleAnswerButtonClick(button) {
    let redirectUrl = button.data("redirect-url");
    let isDecisive = button.data("is-decisive"); // Assuming you store decisiveness in a data attribute

    // If it's a decisive question and the answer is "Yes", store its redirect URL
    if (isDecisive === "yes" && button.hasClass("yes-btn")) {
      decisiveUrl = redirectUrl;
    }

    // Increment the count for the selected redirect URL
    if (redirectUrl && !decisiveUrl) {
      // Only count if no decisive URL is set
      answerCounts[redirectUrl] = (answerCounts[redirectUrl] || 0) + 1;
    }

    // Move to the next question or redirect if this is the last question
    let currentQuestion = button.closest(".elementor-survey__question");
    let nextQuestion = currentQuestion.next(".elementor-survey__question");

    currentQuestion.hide();
    if (nextQuestion.length) {
      nextQuestion.show(); // Show the next question if it exists
    } else {
      // Redirect to the decisive URL if set, else decide based on counts
      window.location.href =
        decisiveUrl ||
        Object.keys(answerCounts).reduce(
          (a, b) => (answerCounts[a] > answerCounts[b] ? a : b),
          Object.keys(answerCounts)[0] // Default to the first URL if no selections
        );
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
