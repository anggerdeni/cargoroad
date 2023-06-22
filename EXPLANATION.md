# Explanation
- Service Repository Pattern  
I implement the Service Repository Pattern in order to achieve better separation of concerns, enhance code maintainability, and facilitate easier testing.

- Spatie Permission  
For efficient role and permission management, I utilize the Spatie library, which provides a comprehensive and flexible solution to handle access control in the application.

- Search Feature  
I have implemented a search feature for both brand and product index endpoints, allowing users to easily find and filter relevant information.

- Unit Test for Service Layer Only  
Due to time constraints, I have added unit tests specifically for the Service layer, ensuring that the core business logic is thoroughly tested and reliable.

- Caching on Repository Layer
I have implemented a caching mechanism on the Repository layer to improve performance, reduce database load, and provide faster response times by storing and retrieving frequently accessed data more efficiently.
I choose to implement it on repository layer so that if we want to turn it on/off we don't need to change much of the service layer.
