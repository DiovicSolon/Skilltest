using ASI.Basecode.Data.Models; // Provides access to the data models, such as the Category class.
using ASI.Basecode.Services.Interfaces; // Provides access to service interfaces, like ICategoryService, for data operations.
using ASI.Basecode.WebApp.Models; // Includes models specific to the web application, such as ErrorViewModel.
using Microsoft.AspNetCore.Authorization; // Enables the use of authorization attributes like [AllowAnonymous].
using Microsoft.AspNetCore.Mvc; // Provides base functionality for controllers in an MVC application.
using Microsoft.Extensions.Logging; // Allows logging for debugging or tracking application events.
using System; // Provides access to base types like Exception and DateTime.
using System.Linq; // Enables LINQ operations, such as filtering, ordering, and selecting data.

namespace ASI.Basecode.WebApp.Controllers // Defines the namespace for the controller.
{
    public class CategoryController : Controller // The controller class to manage Category-related actions.
    {
        private readonly ICategoryService _categoryService; // Service interface to interact with Category data.
        private readonly ILogger<CategoryController> _logger; // Logger instance for tracking errors and events.

        // Constructor to inject dependencies for the service and logger.
        public CategoryController(ICategoryService categoryService, ILogger<CategoryController> logger)
        {
            _categoryService = categoryService; // Assign the injected category service.
            _logger = logger; // Assign the injected logger instance.
        }

        // Helper method to get the logged-in user's ID from the HttpContext.
        private string GetLoggedInUserId()
        {
            return HttpContext.User.Identity.Name; // Retrieves the username of the currently logged-in user.
        }

        // Action to display a paginated list of categories for the logged-in user.
        [AllowAnonymous] // Allows this action to be accessed without authentication.
        public IActionResult Index(int page = 1, int pageSize = 7) // Handles requests for the category list with default pagination values.
        {
            try
            {
                string userId = GetLoggedInUserId(); // Get the ID of the logged-in user.

                var totalCategories = _categoryService.GetAllCategory() // Fetch all categories from the service.
                                       .Where(c => c.UserName == userId) // Filter by categories belonging to the logged-in user.
                                       .OrderByDescending(c => c.DateCreated) // Sort categories by most recent first.
                                       .ToList(); // Convert to a list.

                int totalCategoriesCount = totalCategories.Count; // Get the total count of categories.

                var totalPages = (int)Math.Ceiling((double)totalCategoriesCount / pageSize); // Calculate total number of pages.

                page = Math.Max(1, Math.Min(page, totalPages)); // Ensure the current page is within valid bounds.

                var categories = totalCategories.Skip((page - 1) * pageSize) // Skip categories based on the current page.
                                                .Take(pageSize) // Take only the required number of categories for the page.
                                                .ToList(); // Convert to a list.

                ViewData["CurrentPage"] = page; // Store the current page in ViewData for the view.
                ViewData["TotalPages"] = totalPages; // Store the total number of pages in ViewData for the view.

                return View(categories); // Pass the paginated categories to the view.
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Failed to load categories."); // Log the error.
                return View("Error", new ErrorViewModel { ErrorMessage = "Failed to load categories." }); // Show an error view with a message.
            }
        }

        // Action to display the Create Category view.
        public IActionResult Create()
        {
            return View(new Category { DateCreated = DateTime.Now }); // Pass a new Category instance with the current date to the view.
        }

        // Action to handle the form submission for creating a category.
        [HttpPost] // Indicates this method responds to HTTP POST requests.
        [ValidateAntiForgeryToken] // Protects against cross-site request forgery (CSRF) attacks.
        public IActionResult Create(Category model)
        {
            if (ModelState.IsValid) // Check if the form data is valid.
            {
                try
                {
                    string userId = GetLoggedInUserId(); // Get the ID of the logged-in user.

                    var existingCategory = _categoryService.GetAllCategory() // Check for duplicate categories.
                                            .FirstOrDefault(c => c.CategoryName == model.CategoryName && c.UserName == userId);

                    if (existingCategory != null) // If a duplicate exists:
                    {
                        TempData["ErrorMessage"] = "A category with this name already exists."; // Set an error message.
                        return RedirectToAction(nameof(Create)); // Redirect back to the Create view.
                    }

                    model.UserName = userId; // Assign the logged-in user ID to the category.
                    model.DateCreated = DateTime.Now; // Set the current date for the category.
                    _categoryService.AddCategory(model); // Save the category using the service.

                    TempData["SuccessMessage"] = "Category added successfully!"; // Set a success message.
                    return RedirectToAction(nameof(Index)); // Redirect to the category list.
                }
                catch (Exception ex)
                {
                    _logger.LogError(ex, "Failed to add new category."); // Log the error.
                    TempData["ErrorMessage"] = "Failed to add new category. Please try again."; // Set an error message.
                }
            }

            return View(model); // If invalid or error occurs, return the same view with the model.
        }

        // Action to display the Edit Category view.
        public IActionResult Edit(int id)
        {
            try
            {
                var category = _categoryService.GetCategoryById(id); // Fetch the category by ID.
                if (category == null || category.UserName != GetLoggedInUserId()) // Check if category exists and belongs to the user.
                {
                    TempData["ErrorMessage"] = "Category not found or access denied."; // Set an error message.
                    return RedirectToAction(nameof(Index)); // Redirect to the category list.
                }

                return View(category); // Pass the category to the view for editing.
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error retrieving category for edit."); // Log the error.
                TempData["ErrorMessage"] = "Error retrieving category. Please try again."; // Set an error message.
                return RedirectToAction(nameof(Index)); // Redirect to the category list.
            }
        }

        // Action to handle the form submission for editing a category.
        [HttpPost] // Indicates this method responds to HTTP POST requests.
        [ValidateAntiForgeryToken] // Protects against CSRF attacks.
        public IActionResult Edit(Category model)
        {
            if (ModelState.IsValid) // Check if the form data is valid.
            {
                try
                {
                    var existingCategory = _categoryService.GetCategoryById(model.CategoryId); // Fetch the category by ID.
                    if (existingCategory == null || existingCategory.UserName != GetLoggedInUserId()) // Verify ownership.
                    {
                        TempData["ErrorMessage"] = "Category not found or access denied."; // Set an error message.
                        return RedirectToAction(nameof(Index)); // Redirect to the category list.
                    }

                    var duplicateCategory = _categoryService.GetAllCategory() // Check for duplicate names within the user's categories.
                        .FirstOrDefault(c => c.CategoryName == model.CategoryName
                                             && c.UserName == GetLoggedInUserId()
                                             && c.CategoryId != model.CategoryId);

                    if (duplicateCategory != null) // If a duplicate exists:
                    {
                        TempData["ErrorMessage"] = "A category with this name already exists."; // Set an error message.
                        return RedirectToAction(nameof(Edit), new { id = model.CategoryId }); // Redirect back to the Edit view.
                    }

                    model.DateCreated = existingCategory.DateCreated; // Retain the original creation date.
                    model.UserName = existingCategory.UserName; // Retain the original username.

                    _categoryService.UpdateCategory(model); // Update the category using the service.
                    TempData["SuccessMessage"] = "Category updated successfully!"; // Set a success message.
                    return RedirectToAction(nameof(Index)); // Redirect to the category list.
                }
                catch (Exception ex)
                {
                    _logger.LogError(ex, "Failed to update category."); // Log the error.
                    TempData["ErrorMessage"] = "Failed to update category. Please try again."; // Set an error message.
                }
            }

            return View(model); // If invalid or error occurs, return the same view with the model.
        }

        // Action to delete a category.
        [HttpPost] // Indicates this method responds to HTTP POST requests.
        [ValidateAntiForgeryToken] // Protects against CSRF attacks.
        public IActionResult DeleteConfirmed(int id)
        {
            try
            {
                var category = _categoryService.GetCategoryById(id); // Fetch the category by ID.
                if (category == null || category.UserName != GetLoggedInUserId()) // Verify ownership.
                {
                    TempData["ErrorMessage"] = "Category not found or access denied."; // Set an error message.
                    return RedirectToAction(nameof(Index)); // Redirect to the category list.
                }

                _categoryService.DeleteCategory(id); // Delete the category using the service.
                TempData["SuccessMessage"] = "Category deleted successfully!"; // Set a success message.
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Failed to delete category."); // Log the error.
                TempData["ErrorMessage"] = "Failed to delete category. Please try again."; // Set an error message.
            }

            return RedirectToAction(nameof(Index)); // Redirect to the category list.
        }

        // Action to display the details of a category.
        public IActionResult Details(int id)
        {
            try
            {
                var category = _categoryService.GetCategoryById(id); // Fetch the category by ID.
                if (category == null || category.UserName != GetLoggedInUserId()) // Verify ownership.
                {
                    TempData["ErrorMessage"] = "Category not found or access denied."; // Set an error message.
                    return RedirectToAction(nameof(Index)); // Redirect to the category list.
                }
                return View(category); // Pass the category to the view.
            }
            catch (Exception ex)
            {
                _logger.LogError(ex, "Error retrieving category details."); // Log the error.
                TempData["ErrorMessage"] = "Error retrieving category details. Please try again."; // Set an error message.
                return RedirectToAction(nameof(Index)); // Redirect to the category list.
            }
        }
    }
}
