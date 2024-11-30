let allCourses = [];  


async function fetchCategoriesAndCourses() {
    try {
        const responseCategories = await fetch('http://api.cc.localhost/categories');
        if (!responseCategories.ok) {
            throw new Error('Failed to fetch categories');
        }
        
        const categories = await responseCategories.json();
        const parentCategories = categories.filter(cat => cat.parent === null);

        const responseCourses = await fetch('http://api.cc.localhost/courses');
        if (!responseCourses.ok) {
            throw new Error('Failed to fetch courses');
        }

        allCourses = await responseCourses.json();  

        const buildTree = (parentId) => {
            return categories
                .filter(cat => cat.parent === parentId)
                .map(child => ({
                    ...child,
                    children: buildTree(child.id),
                    courseCount: getCourseCountForCategory(child.id, allCourses) 
                }));
        };

        const categoryTree = parentCategories.map(parent => ({
            ...parent,
            children: buildTree(parent.id),
            courseCount: getCourseCountForCategory(parent.id, allCourses)  
        }));

        renderCategories(categoryTree, document.getElementById('categories-container'));

        renderCourses(allCourses, categories);

        addCategoryClickListeners(categories, allCourses);

    } catch (error) {
        console.error('Error fetching categories or courses:', error);
    }
}

function getCourseCountForCategory(categoryId, courses) {
    return courses.filter(course => course.category_id === categoryId).length;
}

function renderCourses(courses, categories) {
    const coursesContainer = document.getElementById('courses-container');
    coursesContainer.innerHTML = '';  

    const maxTitleLength = 50;  
    const maxDescriptionLength = 100;  

    courses.forEach(course => {
        const category = categories.find(cat => cat.id === course.category_id);
        const categoryName = category ? category.name : 'Unknown Category';

        const truncatedTitle = course.title.length > maxTitleLength 
            ? course.title.substring(0, maxTitleLength) + '...' 
            : course.title;

        const truncatedDescription = course.description.length > maxDescriptionLength 
            ? course.description.substring(0, maxDescriptionLength) + '...' 
            : course.description;

        const courseCard = document.createElement('div');
        courseCard.classList.add('col-md-3', 'col-sm-12', 'col-12','mx-3');
        courseCard.innerHTML = `
            <div class="card">
                <img src="${course.image_preview}" class="card-img-top" alt="${course.title}">
                <div class="card-img-overlay">
                    <span class="btn btn-light">${categoryName}</span>
                </div>
                <div class="card-body">
                    <h5 class="card-title">${truncatedTitle}</h5>
                    <p class="card-text">${truncatedDescription}</p>
                </div>
            </div>
        `;
        coursesContainer.appendChild(courseCard);
    });
}

function renderCategories(categories, container) {
    const ul = document.createElement('ul');
    
    categories.forEach(category => {
        const li = document.createElement('li');
        
        const categoryItem = document.createElement('span');
        categoryItem.id = `category-${category.id}`;  
        categoryItem.classList.add('category-item', 'w-100', 'text-start');
        categoryItem.textContent = `${category.name} ${category.courseCount ? `(${category.courseCount})` : ''}`;
        
        categoryItem.addEventListener('click', () => {
            setActiveCategory(categoryItem); 
            filterCoursesByCategory(category.id); 
        });

        li.appendChild(categoryItem);

        if (category.children && category.children.length > 0) {
            const childContainer = document.createElement('div');
            renderCategories(category.children, childContainer);
            li.appendChild(childContainer);
        }

        ul.appendChild(li);
    });

    container.appendChild(ul);
}


function setActiveCategory(activeItem) {
    const allCategoryItems = document.querySelectorAll('.category-item');
    allCategoryItems.forEach(item => item.classList.remove('active'));

    const allListItems = document.querySelectorAll('li');
    allListItems.forEach(item => item.classList.remove('active'));

    activeItem.classList.add('active');

    let parentLi = activeItem.closest('li');
    while (parentLi) {
        parentLi.classList.add('active');
        parentLi = parentLi.parentElement.closest('li');
    }
}



function filterCoursesByCategory(categoryId) {
    const filteredCourses = allCourses.filter(course => course.category_id === categoryId);
    renderCourses(filteredCourses, allCategories);

    document.querySelector(`#category-${categoryId}`)?.scrollIntoView({
        behavior: 'smooth',
        block: 'center',
    });
}
function addCategoryClickListeners(categories, courses) {
    categories.forEach(category => {
        const categoryButton = document.querySelector(`#category-${category.id}`);
        categoryButton.addEventListener('click', () => {
            const filteredCourses = courses.filter(course => course.category_id === category.id);
            renderCourses(filteredCourses, categories);
        });
    });
}

document.addEventListener('DOMContentLoaded', fetchCategoriesAndCourses);
