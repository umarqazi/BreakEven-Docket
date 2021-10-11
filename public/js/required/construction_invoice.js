function calculate_construction_cost(obj) {
    var area_id = $(obj).closest('.construction_items').attr('id');
    element = $('#'+area_id);
    var estimated_amount = 0;
    var previous_value = 0;
    var project_completed = 0;
    var rentage_held = 0;
    var rentage_held_amount = 0;
    var due_amount = 0;
    var balance_to_finish = 0;

    // Get Values from inputs
    estimated_amount    = element.find('.estimation_amount').val();
    previous_value      = element.find('.previous_amount_recieved').val();
    project_completed   = element.find('.percent_project_completed').val();
    rentage_held        = element.find('.raintage_held_percent').val();

    // Function Call only if these values are defined.
    if (previous_value && project_completed && rentage_held){
        rentage_held_amount = calculate_rentage_cost(estimated_amount, previous_value, rentage_held);
        due_amount = calculate_due_amount(estimated_amount, previous_value, project_completed, rentage_held_amount);
        balance_to_finish = calculate_balance_finish(estimated_amount, previous_value, rentage_held_amount, due_amount);

        // show Calculated Values in Table.
        element.find('.raintage_held_amount').val(rentage_held_amount);
        element.find('.amount_due').val(due_amount);
        element.find('.final_balance').val(balance_to_finish);
    }
}

function calculate_rentage_cost(estimatedCost, recievedAmount, rentage_percent) {
    var remainingAmount = estimatedCost - recievedAmount;
    var rentage = rentage_percent/100;
    var rentageAmount = (remainingAmount*rentage);

    return rentageAmount.toFixed(2);
}

function calculate_due_amount(estimation, previousAmount, projectCompleted, rentage) {
    var project = projectCompleted/100;
    var amount_due = (estimation*project) - previousAmount - rentage;

    return amount_due.toFixed(2);
}

function calculate_balance_finish(estimation, previousAmount, rentageAmount, dueAmount) {
    var amount = estimation - previousAmount - rentageAmount - dueAmount;

    return amount.toFixed(2);
}