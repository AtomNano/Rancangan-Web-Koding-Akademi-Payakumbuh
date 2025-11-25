# Arsitektur PDF Viewer & Pelacakan Progres

## Diagram Arsitektur Sistem

```mermaid
graph TB
    subgraph "Frontend Layer"
        A[Siswa Dashboard] --> B[Daftar Materi]
        B --> C[PDF Viewer Component]
        C --> D[Progress Bar]
        C --> E[Navigation Controls]
        C --> F[Zoom Controls]
    end
    
    subgraph "Backend Layer"
        G[SiswaController] --> H[MateriProgressController]
        H --> I[MateriProgress Model]
        I --> J[Database: materi_progress]
        K[Materi Model] --> I
        L[User Model] --> I
    end
    
    subgraph "Database Schema"
        J --> M[user_id]
        J --> N[materi_id]
        J --> O[current_page]
        J --> P[total_pages]
        J --> Q[progress_percentage]
        J --> R[is_completed]
        J --> S[last_read_at]
    end
    
    subgraph "API Endpoints"
        T[POST /siswa/materi/{id}/progress]
        U[GET /siswa/materi/{id}/progress]
        V[POST /siswa/materi/{id}/mark-completed]
    end
    
    C --> T
    C --> U
    C --> V
    T --> H
    U --> H
    V --> H
```

## Flow Diagram - Proses Pelacakan Progres

```mermaid
sequenceDiagram
    participant S as Siswa
    participant V as PDF Viewer
    participant C as Controller
    participant M as Model
    participant D as Database
    
    S->>V: Buka materi PDF
    V->>C: GET /siswa/materi/{id}/progress
    C->>M: userProgress(userId)
    M->>D: SELECT progress data
    D-->>M: Return progress
    M-->>C: Return progress
    C-->>V: Return JSON progress
    V->>V: Set current page & progress bar
    
    S->>V: Navigasi ke halaman lain
    V->>V: Update current page
    V->>C: POST /siswa/materi/{id}/progress
    Note over V,C: Debounced (1 second)
    C->>M: updateProgress(page, total)
    M->>D: UPDATE materi_progress
    D-->>M: Success
    M-->>C: Updated progress
    C-->>V: Return updated progress
    V->>V: Update progress bar
    
    S->>V: Klik "Tandai Selesai"
    V->>C: POST /siswa/materi/{id}/mark-completed
    C->>M: markAsCompleted()
    M->>D: UPDATE is_completed = true
    D-->>M: Success
    M-->>C: Completed status
    C-->>V: Return completion status
    V->>V: Update UI to completed state
```

## Database Schema

```mermaid
erDiagram
    users {
        bigint id PK
        string name
        string email
        string role
        timestamp created_at
        timestamp updated_at
    }
    
    materis {
        bigint id PK
        string judul
        text deskripsi
        string file_path
        string file_type
        bigint kelas_id FK
        bigint uploaded_by FK
        string status
        timestamp created_at
        timestamp updated_at
    }
    
    materi_progress {
        bigint id PK
        bigint user_id FK
        bigint materi_id FK
        integer current_page
        integer total_pages
        decimal progress_percentage
        boolean is_completed
        timestamp last_read_at
        timestamp created_at
        timestamp updated_at
    }
    
    kelas {
        bigint id PK
        string nama_kelas
        text deskripsi
        string bidang
        string status
        timestamp created_at
        timestamp updated_at
    }
    
    users ||--o{ materi_progress : "has many"
    materis ||--o{ materi_progress : "has many"
    kelas ||--o{ materis : "has many"
    users ||--o{ materis : "uploaded by"
```

## Component Structure

```mermaid
graph TD
    A[PDF Viewer Component] --> B[Progress Bar]
    A --> C[Navigation Controls]
    A --> D[Zoom Controls]
    A --> E[PDF Container]
    A --> F[Completion Button]
    
    B --> B1[Progress Percentage]
    B --> B2[Current Page Info]
    
    C --> C1[Previous Page Button]
    C --> C2[Next Page Button]
    C --> C3[Page Info Display]
    
    D --> D1[Zoom In Button]
    D --> D2[Zoom Out Button]
    D --> D3[Zoom Level Display]
    
    E --> E1[PDF Iframe]
    E --> E2[Download Link]
    
    F --> F1[Mark Completed Button]
    F --> F2[Completion Status]
```

## API Response Examples

### GET Progress Response
```json
{
    "success": true,
    "progress": {
        "current_page": 5,
        "total_pages": 20,
        "progress_percentage": 25.00,
        "is_completed": false,
        "last_read_at": "2025-09-22T10:30:00Z"
    }
}
```

### POST Progress Update Response
```json
{
    "success": true,
    "progress": {
        "current_page": 6,
        "total_pages": 20,
        "progress_percentage": 30.00,
        "is_completed": false,
        "last_read_at": "2025-09-22T10:35:00Z"
    }
}
```

### POST Mark Completed Response
```json
{
    "success": true,
    "message": "Material marked as completed",
    "progress": {
        "current_page": 20,
        "total_pages": 20,
        "progress_percentage": 100.00,
        "is_completed": true,
        "last_read_at": "2025-09-22T10:40:00Z"
    }
}
```
