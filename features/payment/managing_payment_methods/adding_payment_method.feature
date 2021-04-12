@comgate_managing_payment_methods
Feature: Adding a new payment method
    In order to pay for orders in different ways
    As an Administrator
    I want to add a new payment method to the registry

    Background:
        Given the store operates on a single channel in "United States"
        And I am logged in as an administrator

    @ui
    Scenario: Adding a new comgate payment method
        Given I want to create a new payment method with "Comgate" gateway factory
        When I name it "Comgate" in "English (United States)"
        And I specify its code as "comgate"
        And I configure it with test comgate credentials
        And I add it
        Then I should be notified that it has been successfully created
        And the payment method "Comgate" should appear in the registry
