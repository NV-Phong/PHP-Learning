CREATE DATABASE WS_SERVER

USE WS_SERVER

CREATE TABLE USERS 
(
   IDUser 		CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   Username 	VARCHAR(255) UNIQUE NOT NULL,
   Email 		VARCHAR(255) UNIQUE NOT NULL,
   Password 	VARCHAR(255) NOT NULL,
   DisplayName VARCHAR(255),
   Avatar 		VARCHAR(255),
   Cover 		VARCHAR(255),
   IsDeleted 	BOOLEAN NOT NULL DEFAULT FALSE
)

CREATE TABLE TEAM
(
   IDTeam            CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDLeader          CHAR(36) NOT NULL,
   TeamName          VARCHAR(255) UNIQUE NOT NULL,
   TeamSize          INT NOT NULL,
   TeamDescription   TEXT,
   IsDeleted         BOOLEAN NOT NULL DEFAULT FALSE
)

CREATE TABLE TEAM_MEMBERS
(
   IDTeamMember      CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDTeam            CHAR(36) NOT NULL,
   IDUser            CHAR(36) NOT NULL,
   RoleInTeam        VARCHAR(255) NOT NULL,
   JoinAt            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   IsDeleted         BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDTeam) REFERENCES TEAM (IDTeam) ON DELETE CASCADE,
   FOREIGN KEY (IDUser) REFERENCES USERS (IDUser) ON DELETE CASCADE,
   CONSTRAINT unique_team_user UNIQUE (IDTeam, IDUser)
)

CREATE TABLE WORkSPACE
(
   IDWorkSpace          CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDUser               CHAR(36) NOT NULL,
   WorkSpaceName        VARCHAR(255) UNIQUE NOT NULL,
   WorkSpaceDescription TEXT,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE, 
   FOREIGN KEY (IDUser) REFERENCES USERS (IDUser) ON DELETE CASCADE
)

CREATE TABLE WORKSPACE_ACCESS
(
   IDWorkSpaceAccess    CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDWorkSpace          CHAR(36) NOT NULL,
   IDCollaborator       CHAR(36) NOT NULL,
   Permission           ENUM('Leader', 'Member') NOT NULL DEFAULT 'Member',
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDWorkSpace) REFERENCES WORkSPACE (IDWorkSpace) ON DELETE CASCADE,
   FOREIGN KEY (IDCollaborator) REFERENCES USERS (IDUser) ON DELETE CASCADE,
   CONSTRAINT unique_workspace_user UNIQUE (IDWorkSpace, IDCollaborator)
)

CREATE TABLE PRICING
(
   IDPricing            CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   PricingName          VARCHAR(255) UNIQUE NOT NULL,
   Pricing              DECIMAL(10, 2) NOT NULL,
   PricingDescription   TEXT,
   ProjectLimit         INT NOT NULL,
   TeamLimit            INT NOT NULL,
   UnLimitedProjects    BOOLEAN NOT NULL DEFAULT FALSE,
   Duration             ENUM('Monthly', 'Yearly') NOT NULL,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE
)

CREATE TABLE PRICING_PLAN
(
   IDPricingPlan        CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDPricing            CHAR(36) NOT NULL,
   IDUser               CHAR(36) NOT NULL,
   SubscribedAt         TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   ExpiredAt            TIMESTAMP NOT NULL,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDPricing) REFERENCES PRICING (IDPricing) ON DELETE CASCADE,
   FOREIGN KEY (IDUser) REFERENCES USERS (IDUser) ON DELETE CASCADE,
   CONSTRAINT unique_pricing_user UNIQUE (IDPricing, IDUser)
)

CREATE TABLE FEATURE
(
   IDFeature            CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDPricing            CHAR(36) NOT NULL,
   Feature              VARCHAR(255) UNIQUE NOT NULL,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDPricing) REFERENCES PRICING (IDPricing) ON DELETE CASCADE
)

CREATE TABLE QUICK_ACCESS_BAR
(
   IDQuickAccessBar     CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDUser               CHAR(36) NOT NULL,
   URL                  VARCHAR(255) NOT NULL,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDUser) REFERENCES USERS (IDUser) ON DELETE CASCADE
)

CREATE TABLE WIDGET
(
   IDWidget             CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDWorkSpace          CHAR(36) NOT NULL,
   WidgetType           ENUM('Chart', 'Table', 'Text', 'Image', 'Video', 'File') NOT NULL,
   Z_Index              INT NOT NULL,
   Width                INT NOT NULL,
   Height               INT NOT NULL,
   Color                VARCHAR(255),
   PositionX            INT NOT NULL,
   PositionY            INT NOT NULL,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDWorkSpace) REFERENCES WORkSPACE (IDWorkSpace) ON DELETE CASCADE
)

CREATE TABLE NOTE
(
   IDNote               CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDWidget             CHAR(36) NOT NULL,
   Author               CHAR(36) NOT NULL,
   Title                VARCHAR(255) NOT NULL,
   Content              TEXT,
   CreatedAt            TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   IsPublic             BOOLEAN NOT NULL DEFAULT FALSE,
   Thumbnail            VARCHAR(255),
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (Author) REFERENCES USERS (IDUser) ON DELETE CASCADE,
   FOREIGN KEY (IDWidget) REFERENCES WIDGET (IDWidget) ON DELETE CASCADE,
   CONSTRAINT unique_note UNIQUE (IDWidget, IDNote),
   CONSTRAINT unique_note_author UNIQUE (Author, IDNote)
)

CREATE TABLE NOTE_ATTACHMENT
(
   IDNoteAttachment     CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDNote               CHAR(36) NOT NULL,
   FileName             VARCHAR(255) NOT NULL,
   FileType             VARCHAR(255) NOT NULL,
   URL                  VARCHAR(255) NOT NULL,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDNote) REFERENCES NOTE (IDNote) ON DELETE CASCADE
)

CREATE TABLE PROJECT
(
   IDProject            CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDTeam               CHAR(36) NOT NULL,
   ProjectName          VARCHAR(255) UNIQUE NOT NULL,
   ProjectDescription   TEXT,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDTeam) REFERENCES TEAM (IDTeam) ON DELETE CASCADE
)

CREATE TABLE PROJECT_ACCESS
(
   IDProjectAccess      CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDProject            CHAR(36) NOT NULL,
   IDCollaborator       CHAR(36) NOT NULL,
   Permission           ENUM('Leader', 'Member') NOT NULL DEFAULT 'Member',
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDProject) REFERENCES PROJECT (IDProject) ON DELETE CASCADE,
   FOREIGN KEY (IDCollaborator) REFERENCES USERS (IDUser) ON DELETE CASCADE,
   CONSTRAINT unique_project_user UNIQUE (IDProject, IDCollaborator)
)

CREATE TABLE TAG
(
   IDTag                CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDProject            CHAR(36) NOT NULL,
   TagName              VARCHAR(255) UNIQUE NOT NULL,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDProject) REFERENCES PROJECT (IDProject) ON DELETE CASCADE
)

CREATE TABLE STATUS
(
   IDStatus             CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDProject            CHAR(36) NOT NULL,
   Status               VARCHAR(255) UNIQUE NOT NULL,
   StatusOrder          INT NOT NULL, -- đổi thành StatusOrder vì để Order là từ khóa trong SQL =))
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDProject) REFERENCES PROJECT (IDProject) ON DELETE CASCADE
)

CREATE TABLE TASK
(
   IDTask               CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDProject            CHAR(36) NOT NULL,
   IDStatus             CHAR(36) NOT NULL,
   IDTag                CHAR(36) NOT NULL,
   IDAssignee           CHAR(36) NOT NULL,
   TaskName             VARCHAR(255) NOT NULL,
   Priority             ENUM('Low', 'Medium', 'High') NOT NULL DEFAULT 'Low',
   CreateAt             TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   StartDay             TIMESTAMP,
   EndDay               TIMESTAMP,
   DueDay               TIMESTAMP,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDProject) REFERENCES PROJECT (IDProject) ON DELETE CASCADE,
   FOREIGN KEY (IDStatus) REFERENCES STATUS (IDStatus) ON DELETE CASCADE,
   FOREIGN KEY (IDTag) REFERENCES TAG (IDTag) ON DELETE CASCADE,
   FOREIGN KEY (IDAssignee) REFERENCES USERS (IDUser) ON DELETE CASCADE,
   CONSTRAINT unique_task UNIQUE (IDProject, IDTask),
   CONSTRAINT unique_task_status UNIQUE (IDStatus, IDTask),
   CONSTRAINT unique_task_tag UNIQUE (IDTag, IDTask),
   CONSTRAINT unique_task_assignee UNIQUE (IDAssignee, IDTask)
)

CREATE TABLE TASK_ATTACHMENT
(
   IDTaskAttachment     CHAR(36) PRIMARY KEY DEFAULT(UUID()),
   IDTask               CHAR(36) NOT NULL,
   UploadedBy           CHAR(36) NOT NULL,
   FileName             VARCHAR(255) NOT NULL,
   FileType             VARCHAR(255) NOT NULL,
   URL                  VARCHAR(255) NOT NULL,
   UploadedAt           TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
   IsFinalFile          BOOLEAN NOT NULL DEFAULT FALSE,
   IsDeleted            BOOLEAN NOT NULL DEFAULT FALSE,
   FOREIGN KEY (IDTask) REFERENCES TASK (IDTask) ON DELETE CASCADE,
   FOREIGN KEY (UploadedBy) REFERENCES USERS (IDUser) ON DELETE CASCADE,
   CONSTRAINT unique_task_attachment UNIQUE (IDTask, IDTaskAttachment),
   CONSTRAINT unique_task_attachment_user UNIQUE (UploadedBy, IDTaskAttachment)
)