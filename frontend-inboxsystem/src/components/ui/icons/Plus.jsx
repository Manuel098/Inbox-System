const NotificationIcon = ({ size = 24, className = "" }) => {
  return (
    <svg
      xmlns="http://www.w3.org/2000/svg"
      width={size}
      height={size}
      viewBox="0 0 24 24"
      fill="none"
      stroke="currentColor"
      strokeWidth="2"
      className={className}
    >
      <path d="M19,13H13V19H11V13H5V11H11V5H13V11H19V13Z" />
    </svg>
  );
};

export default NotificationIcon;
