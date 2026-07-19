export interface GlobalBtnProps {
  icon: React.ComponentType<{ size?: number; className?: string }>; 
  count?: number;
  onClick?: () => void;
}