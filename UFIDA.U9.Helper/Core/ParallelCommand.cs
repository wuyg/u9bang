using System;
// 引发构造修改行 
namespace UFIDA.U9.Helper
{
    public class ParallelCommandFinishedEventArgs
    {
        private object m_Result;
        public object Result { get { return this.m_Result; } }

        private Exception m_Error;
        public Exception Error { get { return this.m_Error; } }
        public ParallelCommandFinishedEventArgs(object result, Exception error)
        {
            this.m_Result = result;
            this.m_Error = error;
        }
    }
     public interface IParallelCommand 
    {
        void Execute();
        void Finished(ParallelCommandFinishedEventArgs e);
    }
}
